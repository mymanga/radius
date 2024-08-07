<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Client;
use Spatie\Tags\Tag;
use Exception;
use Illuminate\Validation\Rule;
use App\Models\Message;
use App\Models\Template;
use App\Models\Service;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;


class ClientsApiController extends Controller
{
    /**
     * Retrieve a list of all clients with their associated services.
     * A valid API key (`x-api-key`) must be included in the request `header` for authentication.
     *
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/api/clients",
     *     summary="Get All Clients",
     *     tags={"Clients"},
     *     operationId="getAllClients",
     *     security={
     *         {"x-api-key": {}}
     *     },
     *     @OA\Parameter(
     *         name="x-api-key",
     *         in="header",
     *         required=true,
     *         description="API key is required. Example: 3fe15d2c7749b0f4e8d7211a33dbb28c2957e6678e4f472c9cde0836e9a912b7",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="TotalClients",
     *                 type="integer",
     *                 example=225,
     *                 description="Total number of clients"
     *             ),
     *             @OA\Property(
     *                 property="OnlineServicesRevenue",
     *                 type="number",
     *                 format="float",
     *                 example=0,
     *                 description="Total revenue from online services"
     *             ),
     *             @OA\Property(
     *                 property="ActiveServicesRevenue",
     *                 type="number",
     *                 format="float",
     *                 example=2500.00,
     *                 description="Total revenue from active services"
     *             ),
     *             @OA\Property(
     *                 property="InactiveServicesRevenue",
     *                 type="number",
     *                 format="float",
     *                 example=0,
     *                 description="Total revenue from inactive services"
     *             ),
     *             @OA\Property(
     *                 property="clients",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="client_info",
     *                         type="object",
     *                         ref="#/components/schemas/ClientService"
     *                     ),
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized: API key is missing, invalid, or rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4002,
     *                 "message": "Invalid or inactive API key."
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Requests: Rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4003,
     *                 "message": "Too many requests. Please try again later."
     *             }
     *         )
     *     )
     * )
     */
    public function index()
    {
        $totalclients = Client::count();

        // Get distinct IP addresses with null acctstoptime
        $ipaddresses = DB::table('radacct')
            ->whereNull('acctstoptime')
            ->where('framedprotocol', 'PPP')
            ->distinct()
            ->pluck('framedipaddress');

        // Get the sum of the price column for each of these unique IP addresses
        $onlineRevenue = Service::whereIn('ipaddress', $ipaddresses)
            ->where('is_active', 1)
            ->sum('price');

        // Calculate the sum of prices for all active and inactive services
        $activeRevenue = Service::where("is_active", 1)->sum("price");
        $inactiveRevenue = Service::where("is_active", 0)->sum("price");

        $clients = Client::with(['services', 'tags' => function ($query) {
            $query->select('id', 'name');
        }])
            ->select('id', 'firstname', 'lastname', 'username', 'email', 'location', 'latitude', 'longitude', 'phone', 'category', 'billingType', 'birthday', 'identification', 'avatar', 'info', 'created_at', 'updated_at')
            ->get();

        // Modify each client to include wallet balance and status
        $clients->transform(function ($client) {
            // Retrieve the wallet balance
            $walletBalance = $client->wallet->balance;
            $status = $client->apiStatus();

            // Remove the wallet object from the client
            unset($client->wallet);

            // Attach wallet balance and status to the client object
            $client->wallet_balance = $walletBalance;
            $client->status = $status;
             // Include the avatar URL in the client data
             $client->avatar_url = $client->avatar ? asset($client->avatar) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($client->email))) . '?s=100&d=mm&r=g';

             // Remove the avatar relationship to avoid circular reference in JSON response
             unset($client->avatar);

            // Modify each client to include only the tag data
            $client->tags_data = $client->tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name
                ];
            });

            unset($client->tags); // Remove the original tags attribute

            return $client;
        });

        // Return the response with clients data and additional statistics
        return response()->json([
            'TotalClients' => $totalclients,
            'OnlineServicesRevenue' => $onlineRevenue,
            'ActiveServicesRevenue' => $activeRevenue,
            'InactiveServicesRevenue' => $inactiveRevenue,
            'clients' => $clients
        ]);
    }


    /**
     * Create a new client.
     *
     * This endpoint allows creating a new client with the provided data in the request body.
     * A valid API key (`x-api-key`) must be included in the request `header` for authentication.
     *
     * @OA\Post(
     *     path="/api/clients",
     *     summary="Create New Client",
     *     tags={"Clients"},
     *     operationId="createClient",
     *      security={
     *         {"x-api-key": {}}
     *      },
     *      @OA\Parameter(
     *         name="x-api-key",
     *         in="header",
     *         required=true,
     *         description="API key is required. Example: 3fe15d2c7749b0f4e8d7211a33dbb28c2957e6678e4f472c9cde0836e9a912b7",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Client data",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="firstname",
     *                     type="string",
     *                     example="John"
     *                 ),
     *                 @OA\Property(
     *                     property="lastname",
     *                     type="string",
     *                     example="Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="username",
     *                     type="string",
     *                     example="johndoe"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="john@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="password"
     *                 ),
     *                 @OA\Property(
     *                     property="location",
     *                     type="string",
     *                     example="New York"
     *                 ),
     *                 @OA\Property(
     *                     property="latitude",
     *                     type="string",
     *                     example="40.7128"
     *                 ),
     *                 @OA\Property(
     *                     property="longitude",
     *                     type="string",
     *                     example="-74.0060"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     example="1234567890"
     *                 ),
     *                 @OA\Property(
     *                     property="category",
     *                     type="string",
     *                     enum={"individual", "business"},
     *                     example="individual"
     *                 ),
     *                 @OA\Property(
     *                     property="billingType",
     *                     type="string",
     *                     enum={"monthly", "recurring"},
     *                     example="monthly"
     *                 ),
     *                 @OA\Property(
     *                     property="birthday",
     *                     type="string",
     *                     example="1990-01-01"
     *                 ),
     *                 @OA\Property(
     *                     property="identification",
     *                     type="string",
     *                     example="ID123"
     *                 ),
     *                 @OA\Property(
     *                     property="avatar",
     *                     type="string",
     *                     example="avatar.jpg"
     *                 ),
     *                 @OA\Property(
     *                     property="info",
     *                     type="string",
     *                     example="Additional information"
     *                 ),
     *                 @OA\Property(
     *                     property="tags",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         example="tag1"
     *                     )
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error: Invalid input data",
     *         @OA\JsonContent(
     *             example={"errors": {"field_name": {"error_message"}}}
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error: Failed to create client",
     *         @OA\JsonContent(
     *             example={"message": "Internal Server Error: Failed to create client"}
     *         )
     *     ),
     *      @OA\Response(
     *         response=401,
     *         description="Unauthorized: API key is missing, invalid, or rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4002,
     *                 "message": "Invalid or inactive API key."
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Requests: Rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4003,
     *                 "message": "Too many requests. Please try again later."
     *             }
     *         )
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request  $request The request object
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        try {
            // Validate the request data
            $validatedData = $this->validateClientData($request);

            // Set the value of text_pass to the password
            $validatedData['text_pass'] = $validatedData['password'];

            // Include other optional attributes in the validated data
            $validatedData['location'] = $request->input('location');
            $validatedData['latitude'] = $request->input('latitude');
            $validatedData['longitude'] = $request->input('longitude');
            $validatedData['birthday'] = $request->input('birthday');
            $validatedData['identification'] = $request->input('identification');
            $validatedData['info'] = $request->input('info');

            // Create the client
            $client = $this->createClient($validatedData);

            // Format and save the client's phone number
            $formattedPhone = formatted_phone_number($request->phone);
            if (!empty($formattedPhone)) {
                $client->phone = $formattedPhone;
                $client->save();
            }

            // Sync tags with the client
            if (!empty($request->tags)) {
                $tags = collect($request->tags)->map(function ($tagName) {
                    return Tag::findOrCreateFromString($tagName);
                });

                $client->syncTags($tags);
            }

            // Send notifications if enabled
            $smssent = "";
            $smsfailed = "";
            $emailsent = "";
            $emailfailed = "";

            try {
                if (!empty($client->phone) && setting("sms") == "enabled" && setting("smsnotification") == "enabled" && setting("welcomemessage") == "enabled") {
                    $smssent = $this->sendSmsNotification($client, "Welcome to the company!");
                }

                if (!empty($client->email) && setting("emailnotification") == "enabled" && setting("welcomemessage") == "enabled") {
                    $emailsent = $this->sendEmailNotification($client, "Welcome to the company!");
                }
            } catch (Exception $e) {
                // Log the error
                logger()->error($e);
            }

             // Include the avatar URL in the client data
             $client->avatar_url = $client->avatar ? asset($client->avatar) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($client->email))) . '?s=100&d=mm&r=g';

             // Remove the avatar relationship to avoid circular reference in JSON response
             unset($client->avatar);

            // Log activity
            activity()
                ->performedOn($client)
                ->withProperties(['action' => 'created'])
                ->log('Created client'.' '.$client->username);

            // Return the newly created client as JSON response
            return response()->json($client, 201);
        } catch (ValidationException $e) {
            // Return validation errors as JSON response
            return response()->json(['errors' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            // Return the actual error message as JSON response
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Validate client data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function validateClientData(Request $request)
    {
        return $request->validate([
            'username' => ['required', 'unique:radcheck', 'unique:users'],
            'password' => ['required'],
            'firstname' => ['required'],
            'lastname' => ['nullable'],
            'email' => ['nullable', 'email', 'unique:users'],
            'phone' => [
                'nullable',
                'sometimes',
                'size:10',
                function ($attribute, $value, $fail) {
                    if (!empty($value) && empty(formatted_phone_number($value))) {
                        $fail("The $attribute must be a valid formatted phone number.");
                    }
                },
            ],
            'category' => ['required', Rule::in(['individual', 'business'])],
            'billingType' => ['required', Rule::in(['monthly', 'recurring'])],
        ]);
    }

    /**
     * Create a new client.
     *
     * @param  array  $data
     * @return \App\Models\Client
     */
    private function createClient(array $data)
    {
        return Client::create($data);
    }

    // The createClient function remains unchanged

    private function sendSmsNotification(Client $client, string $message)
    {
        $status = "";

        if (setting("sms") == "enabled" && setting("smsnotification") == "enabled" && setting("welcomemessage") == "enabled") {
            $template = template(setting("welcomesms"));
            $message = $template ? message($client, $template->content) : "Dear " . $client->firstname . ", Welcome to " . setting("company") . ". Your account has been created";

            // Get the SMS gateway settings
            $gateway = setting("smsgateway");
            $sender_id = setting($gateway . "_sender_id");
            $gateway_name = setting($gateway . "_gateway");

            // Send the SMS using the gateway
            $result = sendSms($client->phone, $message);

            // Save the SMS details to the database
            $sms = new Message();
            $sms->user_id = $client->id;
            $sms->sender = $sender_id;
            $sms->message = $message;
            $sms->gateway = $gateway_name;
            $sms->status = $result ? "Sent" : "Failed";
            $sms->save();

            $status = $result ? "SMS was sent successfully using " . $gateway . " gateway" : "Failed to send SMS";
        }

        return $status;
    }

    private function sendEmailNotification(Client $client, string $message)
    {
        $status = "";

        if (setting("emailnotification") == "enabled" && setting("welcomemessage") == "enabled") {
            $template = template(setting("welcomemail"));
            $content = $template ? message($client, $template->content) : "Dear " . $client->firstname . ", Welcome to " . setting("company") . ". Your account has been created";
            try {
                // Attempt to send the welcome email to the client
                Mail::to($client->email)->send(new WelcomeEmail($content));

                // Log the successful email sending
                Log::info("Email sent to " . $client->email);
                $status = "Email sent successfully";
            } catch (\Exception $e) {
                // Log the email sending error
                Log::error("Failed to send email to " . $client->email . ": " . $e->getMessage());
                $status = "Failed to send email";
            }
        }

        return $status;
    }

    /**
     * Display the specific client data.
     *
     * This GET endpoint retrieves detailed information about a specific `client` identified by their `username`. 
     * A valid API key (`x-api-key`) must be included in the request `header` for authentication. 
     * The `username` parameter in the `URI` specifies the target client whose details will be retrieved. 
     * Upon successful execution, a `200` response is returned, client data. 
     * If the requested client is not found, a 404 response is returned with a corresponding error message. 
     * Error responses also handle unauthorized access and rate limit exceeded scenarios with appropriate error messages.
     *
     * @OA\Get(
     *     path="/api/clients/{username}",
     *     summary="Get Client Details",
     *     tags={"Clients"},
     *     operationId="getClientDetails",
     *     security={
     *         {"x-api-key": {}}
     *      },
     *      @OA\Parameter(
     *         name="x-api-key",
     *         in="header",
     *         required=true,
     *         description="API key is required. Example: 3fe15d2c7749b0f4e8d7211a33dbb28c2957e6678e4f472c9cde0836e9a912b7",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         description="Client username",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 example=4
     *             ),
     *             @OA\Property(
     *                 property="firstname",
     *                 type="string",
     *                 example="John"
     *             ),
     *             @OA\Property(
     *                 property="lastname",
     *                 type="string",
     *                 example="Doe"
     *             ),
     *             @OA\Property(
     *                 property="username",
     *                 type="string",
     *                 example="270653"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 example="john.doe@example.com"
     *             ),
     *             @OA\Property(
     *                 property="location",
     *                 type="string",
     *                 example="New York"
     *             ),
     *             @OA\Property(
     *                 property="latitude",
     *                 type="string",
     *                 example="40.7128"
     *             ),
     *             @OA\Property(
     *                 property="longitude",
     *                 type="string",
     *                 example="-74.0060"
     *             ),
     *             @OA\Property(
     *                 property="phone",
     *                 type="string",
     *                 example="1234567890"
     *             ),
     *             @OA\Property(
     *                 property="category",
     *                 type="string",
     *                 example="individual"
     *             ),
     *             @OA\Property(
     *                 property="billingType",
     *                 type="string",
     *                 example="monthly"
     *             ),
     *             @OA\Property(
     *                 property="birthday",
     *                 type="string",
     *                 example="1990-01-01"
     *             ),
     *             @OA\Property(
     *                 property="identification",
     *                 type="string",
     *                 example="ABC123"
     *             ),
     *             @OA\Property(
     *                 property="avatar",
     *                 type="string",
     *                 example="http://example.com/avatar.jpg"
     *             ),
     *             @OA\Property(
     *                 property="type",
     *                 type="string",
     *                 example="client"
     *             ),
     *             @OA\Property(
     *                 property="text_pass",
     *                 type="string",
     *                 example="password"
     *             ),
     *             @OA\Property(
     *                 property="info",
     *                 type="object",
     *                 description="Additional information",
     *                 @OA\Property(
     *                      property="key",
     *                     type="string",
     *                    example="value"
     *                )
     *             ),
     *             @OA\Property(
     *                 property="email_verified_at",
     *                 type="string",
     *                 format="date-time",
     *                 example="2024-04-02T10:46:54.000000Z"
     *             ),
     *             @OA\Property(
     *                 property="created_at",
     *                 type="string",
     *                 format="date-time",
     *                 example="2023-05-27T11:26:22.000000Z"
     *             ),
     *             @OA\Property(
     *                 property="updated_at",
     *                 type="string",
     *                 format="date-time",
     *                 example="2024-04-02T10:46:54.000000Z"
     *             ),
     *             @OA\Property(
     *                 property="wallet_balance",
     *                 type="string",
     *                 example="0"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="Active"
     *             ),
     *             @OA\Property(
     *                 property="tags_data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=56
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Tag Name 1"
     *                     )
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="services",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=37
     *                     ),
     *                     @OA\Property(
     *                         property="user_id",
     *                         type="integer",
     *                         example=4
     *                     ),
     *                     @OA\Property(
     *                         property="package_id",
     *                         type="integer",
     *                         example=6
     *                     ),
     *                     @OA\Property(
     *                         property="nas_id",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="price",
     *                         type="string",
     *                         example="3500.00"
     *                     ),
     *                     @OA\Property(
     *                         property="username",
     *                         type="string",
     *                         example="270653"
     *                     ),
     *                     @OA\Property(
     *                         property="cleartextpassword",
     *                         type="string",
     *                         example="password"
     *                     ),
     *                     @OA\Property(
     *                         property="ipaddress",
     *                         type="string",
     *                         example="102.100.0.5"
     *                     ),
     *                     @OA\Property(
     *                         property="is_active",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="renewal",
     *                         type="string",
     *                         example="2024-03-27"
     *                     ),
     *                     @OA\Property(
     *                         property="expiry",
     *                         type="string",
     *                         example="2024-04-09T21:00:00.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         example="Service description"
     *                     ),
     *                     @OA\Property(
     *                         property="grace_expiry",
     *                         type="string",
     *                         example="2024-04-09T21:00:00.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="deleted_at",
     *                         type="string",
     *                         format="date-time",
     *                         example=null
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         format="date-time",
     *                         example="2023-10-05T19:14:58.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         format="date-time",
     *                         example="2024-03-29T21:22:19.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="mac_address",
     *                         type="string",
     *                         example="00:0a:95:9d:68:16"
     *                     ),
     *                     @OA\Property(
     *                         property="type",
     *                         type="string",
     *                         example="PPP"
     *                     ),
     *                     @OA\Property(
     *                         property="info",
     *                         type="object",
     *                         @OA\Property(
     *                             property="changed",
     *                             type="string",
     *                             example="2024-03-30"
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found: Client not found",
     *         @OA\JsonContent(
     *             example={"message": "client not found"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized: API key is missing, invalid, or rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4002,
     *                 "message": "Invalid or inactive API key."
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Requests: Rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4003,
     *                 "message": "Too many requests. Please try again later."
     *             }
     *         )
     *     )
     * )
     */

    public function show($username)
    {
        // Search for the client by username
        $client = Client::with('services')->where('username', $username)->first();

        // Check if the client exists
        if (!$client) {
            return response()->json(['message' => 'client not found'], 404);
        }

        // Modify the services to set type to "PPP" if it's null
        foreach ($client->services as $service) {
            if (is_null($service->type)) {
                $service->type = 'PPP';
            }
        }

        // Retrieve the wallet balance
        $walletBalance = $client->wallet->balance;
        $status = $client->apiStatus();

        // Remove the wallet object from the client
        unset($client->wallet);

        // Attach wallet balance and status to the client object
        $client->wallet_balance = $walletBalance;
        $client->status = $status;

         // Include the avatar URL in the client data
         $client->avatar_url = $client->avatar ? asset($client->avatar) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($client->email))) . '?s=100&d=mm&r=g';

         // Remove the avatar relationship to avoid circular reference in JSON response
         unset($client->avatar);

        // Retrieve the client's tags with only id and name attributes
        $tags = $client->tags()->select('id', 'name')->get()->map(function ($tag) {
            return [
                'id' => $tag->id,
                'name' => $tag->name
            ];
        });

        // Add the tags to the client object
        $client->tags_data = $tags;

        // Return the API client with loaded services, wallet balance, status, and tags
        return response()->json($client);
    }


    /**
     * Get transactions for a specific client.
     * 
     * This GET endpoint retrieves `transactions` for a specific `client` identified by their `username`. 
     * A valid API key (`x-api-key`) must be included in the request `header` for authentication. 
     * The `username` parameter in the `URI` specifies the target client whose transactions will be retrieved. 
     * Upon successful execution, a `200` response is returned, containing an array of transactions. 
     * If the requested client is not found, a 404 response is returned with a corresponding error message. 
     * Error responses also handle unauthorized access and rate limit exceeded scenarios with appropriate error messages.
     *
     * @param  string  $username
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/clients/{username}/transactions",
     *     summary="Get Transactions",
     *     tags={"Clients"},
     *     operationId="getTransactions",
     *     security={
     *         {"x-api-key": {}}
     *      },
     *      @OA\Parameter(
     *         name="x-api-key",
     *         in="header",
     *         required=true,
     *         description="API key is required. Example: 3fe15d2c7749b0f4e8d7211a33dbb28c2957e6678e4f472c9cde0836e9a912b7",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="Username of the client",
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         example="john_doe"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="Transaction ID"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     description="Transaction type"
     *                 ),
     *                 @OA\Property(
     *                     property="amount",
     *                     type="float",
     *                     description="Transaction amount"
     *                 ),
     *                 @OA\Property(
     *                     property="meta",
     *                     type="object",
     *                     description="Additional metadata"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Transaction creation timestamp"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Transaction update timestamp"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found: Client not found",
     *         @OA\JsonContent(
     *             example={"message": "client not found"}
     *         )
     *     ),
     *    @OA\Response(
     *         response=401,
     *         description="Unauthorized: API key is missing, invalid, or rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4002,
     *                 "message": "Invalid or inactive API key."
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Requests: Rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4003,
     *                 "message": "Too many requests. Please try again later."
     *             }
     *         )
     *     )
     * )
     */
    public function transactions($username)
    {
        // Find the client by username
        $client = Client::where('username', $username)->first();

        // Check if the client exists
        if (!$client) {
            return response()->json(['message' => 'client not found'], 404);
        }

        // Retrieve only specific columns for transactions
        $transactions = $client->transactions()->select('id', 'type', 'amount', 'meta', 'created_at', 'updated_at')->get();

        // Return the transactions
        return response()->json($transactions);
    }

    /**
     * Update user wallet balance by adding payment.
     * 
     * This POST endpoint enables the manual addition of payments to a client's account. 
     * A valid API key (`x-api-key`) must be included in the request header for authentication. 
     * The `username` parameter in the URI specifies the target client whose account will receive the payment. 
     * The request body should contain a JSON payload with the `amount` property indicating the amount to be deposited. 
     * Optionally, the `reference` property can be included to provide a reference for the payment, and the `description` property allows for a description of the payment.
     *  Upon successful execution, a `200` response is returned, confirming that the client's wallet was successfully credited. 
     * The response includes a message confirming the credit, the updated wallet balance, and a `notification_result` object containing details about any SMS or email notifications sent. 
     * If the request fails validation, a `400` response is returned, detailing the validation error. 
     * In case of an internal server error during payment processing, a 500 response is returned. Additionally, error responses handle unauthorized access and rate limit exceeded scenarios with appropriate error messages.
     * 
     * @OA\Post(
     *     path="/api/clients/{username}/payment",
     *     summary="Manually add payment to client account",
     *     tags={"Clients"},
     *     operationId="AddClientPayment",
     *      security={
     *         {"x-api-key": {}}
     *      },
     *      @OA\Parameter(
     *         name="x-api-key",
     *         in="header",
     *         required=true,
     *         description="API key is required. Example: 3fe15d2c7749b0f4e8d7211a33dbb28c2957e6678e4f472c9cde0836e9a912b7",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="Username of the client",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"amount"},
     *             @OA\Property(property="amount", type="number", example="100.00", description="Amount to deposit"),
     *             @OA\Property(property="reference", type="string", example="123456", description="Reference for the payment (optional)"),
     *             @OA\Property(property="description", type="string", example="Payment description", description="Description of the payment (optional)")
     *         )
     *     ),
     *     @OA\Response(
     *     response="200",
     *     description="Success response",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Client wallet successfully credited"),
     *         @OA\Property(property="wallet", type="number", format="float", example="300", description="Client wallet balance after credit"),
     *         @OA\Property(property="notification_result", type="object",
     *             @OA\Property(property="smssent", type="string", example="Sms was sent successfully using sms gateway"),
     *             @OA\Property(property="smsfailed", type="string", example=""),
     *             @OA\Property(property="emailsent", type="string", example=""),
     *             @OA\Property(property="emailfailed", type="string", example="")
     *         )
     *        )
     *      ),
     *     @OA\Response(
     *         response="400",
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Validation failed")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Payment processing failed")
     *         )
     *     ),
     *    @OA\Response(
     *         response=401,
     *         description="Unauthorized: API key is missing, invalid, or rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4002,
     *                 "message": "Invalid or inactive API key."
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Requests: Rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4003,
     *                 "message": "Too many requests. Please try again later."
     *             }
     *         )
     *     )
     * )
     */
    public function payment(Request $request, $username): JsonResponse
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric',
                'description' => 'nullable|string',
                'reference' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Find the client associated with the given username
            $client = Client::where('username', $username)->first();

            // Deposit the requested amount into the client's account
            $client->deposit($request->amount, [
                'description' => $request->description,
                'title' => $request->reference,
            ]);

            // Initialize variables for SMS and email notifications
            $notificationResult = send_payment_notification($client, $request->amount, $client->phone);

            // Return JSON response
            return response()->json([
                'message' => 'Client wallet successfully credited',
                'wallet' => $client->balance,
                'notification_result' => $notificationResult,
            ]);
        } catch (ValidationException $e) {
            // Return validation errors as JSON response
            return response()->json(['errors' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            // Log or handle the exception
            return response()->json(['error' => 'Payment processing failed'], 500);
        }
    }

    
    /**
     * Update user wallet balance
     * 
     * This endpoint allows for the `modification` of a client's `wallet balance`. 
     * A valid API key (`x-api-key`) must be included in the request `header` for authentication. 
     * The `username` parameter in the `URI` specifies the target client whose wallet balance is to be updated. 
     * The request body must contain a JSON payload with the `newWalletBalance` property, indicating the new wallet balance to be set. 
     * Upon successful execution, a `200` response is returned, indicating that the wallet balance was updated successfully. 
     * The response includes a status message confirming the update and the updated wallet balance. 
     * If the request fails validation, a `400` response is returned, detailing the validation error. 
     * In case the specified client is `not found`, a `404` response is returned. 
     * Additionally, error responses handle unauthorized access and rate limit exceeded scenarios with appropriate error messages.
     * 
     * @OA\Put(
     *     path="/api/clients/{username}/update-wallet-balance",
     *     summary="Modify clients's wallet balance",
     *     tags={"Clients"},
     *     operationId="UpdateWalletBalance",
     *      security={
     *         {"x-api-key": {}}
     *      },
     *      @OA\Parameter(
     *         name="x-api-key",
     *         in="header",
     *         required=true,
     *         description="API key is required. Example: 3fe15d2c7749b0f4e8d7211a33dbb28c2957e6678e4f472c9cde0836e9a912b7",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="Username of the client",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"newWalletBalance"},
     *             @OA\Property(property="newWalletBalance", type="number", example="100.00", description="New wallet balance")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success response",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Wallet balance updated successfully"),
     *             @OA\Property(property="wallet_balance", type="number", example="100.00", description="Updated wallet balance")
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Validation failed")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Client not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Client not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized: API key is missing, invalid, or rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4002,
     *                 "message": "Invalid or inactive API key."
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Requests: Rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4003,
     *                 "message": "Too many requests. Please try again later."
     *             }
     *         )
     *     )
     * )
     */
    public function updateWalletBalance(Request $request, $username): JsonResponse
    {
        try {
            // Retrieve client based on username
            $client = Client::where('username', $username)->first();
            if (!$client) {
                return response()->json(['error' => 'Client not found'], 404);
            }

            $request->validate([
                'newWalletBalance' => 'required|numeric|min:0',
            ]);
            
            // Retrieve the client's wallet and its old balance
            $wallet = $client->wallet;
            $oldBalance = $wallet->balance;
            
            // Update the wallet's balance with the new value
            $wallet->balance = $request->newWalletBalance;
            $wallet->save();

            // Log the activity of updating wallet balance
            activity()
                ->performedOn($client)
                ->withProperties(['action' => 'updateWallet'])
                ->log('Updated wallet balance for client ' . $client->username . ' from ' . $oldBalance . ' to ' . $request->newWalletBalance);

            // Respond with success message and updated wallet balance
            return response()->json([
                'status' => 'Wallet balance updated successfully',
                'wallet_balance' => $request->newWalletBalance,
            ]);
        } catch (ValidationException $e) {
            // Return validation errors as JSON response
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
         catch (\Exception $e) {
            // Log or handle the exception
            Log::error('Error updating wallet balance: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update wallet balance'], 500);
        }
    }





    /**
     * Get invoices for a specific client.
     * 
     * This GET endpoint retrieves `invoices` associated with a specific `client` identified by their `username`. 
     * The `username` parameter in the `URI` denotes the target `client`. 
     * Accessing the endpoint requires a valid API key (`x-api-key`) provided in the request `header` for authentication. 
     * Upon successful retrieval, a `200` response delivers an array of `invoice` objects containing details such as invoice ID, user ID, service ID, invoice number, amount, status, due date, and timestamps of creation and last update. 
     * In case the specified client is not found, a `404` response is returned. Additionally, error responses handle scenarios of unauthorized access and rate limit exceeded with appropriate error messages. 
     *
     * @param  string  $username
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/clients/{username}/invoices",
     *     summary="Get Invoices",
     *     tags={"Clients"},
     *     operationId="getInvoices",
     *     security={
     *         {"x-api-key": {}}
     *      },
     *      @OA\Parameter(
     *         name="x-api-key",
     *         in="header",
     *         required=true,
     *         description="API key is required. Example: 3fe15d2c7749b0f4e8d7211a33dbb28c2957e6678e4f472c9cde0836e9a912b7",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="Username of the client",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=135
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     example=4
     *                 ),
     *                 @OA\Property(
     *                     property="service_id",
     *                     type="integer",
     *                     example=37
     *                 ),
     *                 @OA\Property(
     *                     property="invoice_number",
     *                     type="string",
     *                     example="INV-15789846"
     *                 ),
     *                 @OA\Property(
     *                     property="amount",
     *                     type="string",
     *                     example="2500.00"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="paid"
     *                 ),
     *                 @OA\Property(
     *                     property="due_date",
     *                     type="string",
     *                     example="2024-03-16"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-03-09T08:27:27.000000Z"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-03-09T08:27:27.000000Z"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="client not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="client not found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized: API key is missing, invalid, or rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4002,
     *                 "message": "Invalid or inactive API key."
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Requests: Rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4003,
     *                 "message": "Too many requests. Please try again later."
     *             }
     *         )
     *     )
     * )
     */
    public function invoices($username)
    {
        // Find the client by username
        $client = Client::where('username', $username)->first();

        // Check if the client exists
        if (!$client) {
            return response()->json(['message' => 'client not found'], 404);
        }

        // Retrieve the invoices for the client
        $invoices = $client->invoices;

        // Return the invoices
        return response()->json($invoices);
    }


    /**
     * Update the specified client data.
     *
     * This endpoint allows updating the information of a specific `client` identified by their `username`.
     * It expects a JSON payload containing the new data to be updated. The `username` parameter in the `URI`
     * determines which `client's` data will be updated. Authentication is required, and it expects a valid API key (`x-api-key`) to be included in the request header
     * Unauthorized requests are handled with a `401` response, and rate-limit exceeded scenarios are managed with a `429` response, each accompanied by appropriate error messages.
     *
     * @OA\Put(
     *     path="/api/clients/{username}",
     *     summary="Update Client Data",
     *     tags={"Clients"},
     *     operationId="updateClient",
     *     security={
     *         {"x-api-key": {}}
     *      },
     *      @OA\Parameter(
     *         name="x-api-key",
     *         in="header",
     *         required=true,
     *         description="API key is required. Example: 3fe15d2c7749b0f4e8d7211a33dbb28c2957e6678e4f472c9cde0836e9a912b7",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="The client being updated username/account number",
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         example="example_username"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="New client data",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={
     *                     "firstname",
     *                     "category",
     *                     "billingType"
     *                 },
     *                 @OA\Property(
     *                     property="firstname",
     *                     type="string",
     *                     example="John"
     *                 ),
     *                 @OA\Property(
     *                     property="lastname",
     *                     type="string",
     *                     nullable=true,
     *                     example="Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="username",
     *                     type="string",
     *                     example="example_username"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     nullable=true,
     *                     example="john@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     nullable=true,
     *                     example="new_password"
     *                 ),
     *                 @OA\Property(
     *                     property="location",
     *                     type="string",
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="latitude",
     *                     type="string",
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="longitude",
     *                     type="string",
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="category",
     *                     type="string",
     *                     enum={"individual", "business"},
     *                     example="individual"
     *                 ),
     *                 @OA\Property(
     *                     property="billingType",
     *                     type="string",
     *                     enum={"monthly", "recurring"},
     *                     example="monthly"
     *                 ),
     *                 @OA\Property(
     *                     property="birthday",
     *                     type="string",
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="identification",
     *                     type="string",
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="avatar",
     *                     type="string",
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="info",
     *                     type="string",
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="tags",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         example="tag1"
     *                     ),
     *                     nullable=true
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             example={
     *                 "id": 1,
     *                 "firstname": "John",
     *                 "lastname": "Doe",
     *                 "username": "example_username",
     *                 "email": "john@example.com",
     *                 "location": "New York",
     *                 "latitude": "40.7128",
     *                 "longitude": "-74.0060",
     *                 "phone": "+1234567890",
     *                 "category": "individual",
     *                 "billingType": "monthly",
     *                 "birthday": "1990-01-01",
     *                 "identification": "12345",
     *                 "avatar": "avatar_url",
     *                 "info": "Additional information",
     *                 "tags": {"tag1", "tag2"}
     *             }
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request: Validation error",
     *         @OA\JsonContent(
     *             example={"errors": {"username": {"The username field is required."}}}
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found: Client not found",
     *         @OA\JsonContent(
     *             example={"message": "client not found"}
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity: Validation error",
     *         @OA\JsonContent(
     *             example={"errors": {"password": {"The password must be at least 8 characters."}}}
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error: Failed to update client",
     *         @OA\JsonContent(
     *             example={"message": "Internal Server Error: Failed to update client"}
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized: API key is missing, invalid, or rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4002,
     *                 "message": "Invalid or inactive API key."
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Requests: Rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4003,
     *                 "message": "Too many requests. Please try again later."
     *             }
     *         )
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $username The client being updated username/account number.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $username)
    {
        // Search for the client by username
        $client = Client::where('username', $username)->first();

        // Check if the client exists
        if (!$client) {
            return response()->json(['message' => 'client not found'], 404);
        }

        try {
            // Validate the request data
            $validatedData = $request->validate([
                'username' => [
                    'required',
                    Rule::unique('radcheck', 'username')->ignore($client->username, 'username'),
                    Rule::unique('users', 'username')->ignore($client->username, 'username'),
                ],
                'password' => ['sometimes', 'nullable', 'min:8'],
                'firstname' => ['required'],
                'lastname' => ['nullable', 'sometimes', 'string'],
                'email' => ['nullable', 'sometimes', 'email', Rule::unique('users', 'email')->ignore($client->id)],
                "phone" => [
                    "nullable",
                    "sometimes",
                    function ($attribute, $value, $fail) {
                        if (!empty($value) && empty(formatted_phone_number($value))) {
                            $fail("The $attribute must be a valid formatted phone number.");
                        }
                    },
                ],
                'category' => ['required', Rule::in(['individual', 'business'])],
                'billingType' => ['required', Rule::in(['monthly', 'recurring'])],
            ]);

            // Update individual fillable attributes except for 'type'
            $client->username = $validatedData['username'];
            $client->password = $validatedData['password'];
            $client->firstname = $validatedData['firstname'];
            $client->lastname = $validatedData['lastname'];
            $client->email = $validatedData['email'];
            $client->phone = formatted_phone_number($validatedData['phone']);
            $client->category = $validatedData['category'];
            $client->billingType = $validatedData['billingType'];

            // Update other fillable attributes
            $client->location = $request->input('location');
            $client->latitude = $request->input('latitude');
            $client->longitude = $request->input('longitude');
            $client->birthday = $request->input('birthday');
            $client->identification = $request->input('identification');
            $client->info = $request->input('info');
            $client->text_pass = $validatedData['password'];

            // Save the updated client object to the database
            $client->save();

            // Sync tags with the client
            if (!empty($request->tags)) {
                $tags = collect($request->tags)->map(function ($tagName) {
                    return Tag::findOrCreateFromString($tagName);
                });

                $client->syncTags($tags);
            } else {
                // If no tags are selected, remove all existing tags from the client
                $client->syncTags([]);
            }

            // Log activity
            activity()
                ->performedOn($client)
                ->withProperties(['action' => 'updated'])
                ->log('Updated client'.' '.$client->username.' '.' details');

            // Return the updated client as JSON response
            return response()->json($client);
        } catch (ValidationException $e) {
            // Return validation errors as JSON response
            return response()->json(['errors' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            // Return the actual error message as JSON response
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Get usage statistics for specific service
     * 
     * Upon successful invocation of the endpoint, you receive an instance of the `client` details, together with their subscibed `services`. 
     * In addition to the client data, you also receive the total `download` and `upload` usage in (`GB`), the usage period, for the selected service, in the last `12 month` period grouped per `month`.
     * Authentication is required, and it expects a valid API key (`x-api-key`) to be included in the request header
     * Unauthorized requests are handled with a `401` response, and rate-limit exceeded scenarios are managed with a `429` response, each accompanied by appropriate error messages.
     * 
     * @OA\Get(
     *     path="/api/clients/{username}/statistics",
     *     summary="Get usage statistics for a service",
     *     tags={"Clients"},
     *     operationId="getUsageStatistics",
     *      security={
     *         {"x-api-key": {}}
     *      },
     *      @OA\Parameter(
     *         name="x-api-key",
     *         in="header",
     *         required=true,
     *         description="API key is required. Example: 3fe15d2c7749b0f4e8d7211a33dbb28c2957e6678e4f472c9cde0836e9a912b7",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="Username of the client",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="interface",
     *         in="query",
     *         required=false,
     *         description="Username of the service being queried",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="client",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="client_info",
     *                         type="object",
     *                         ref="#/components/schemas/ClientService"
     *                     ),
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="download",
     *                 type="number",
     *                 format="float",
     *                 description="Total download in GB"
     *             ),
     *             @OA\Property(
     *                 property="upload",
     *                 type="number",
     *                 format="float",
     *                 description="Total upload in GB"
     *             ),
     *             @OA\Property(
     *                 property="period",
     *                 type="array",
     *                 description="Usage period",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="month",
     *                         type="string",
     *                         description="Usage month"
     *                     ),
     *                     @OA\Property(
     *                         property="GB_in",
     *                         type="number",
     *                         format="float",
     *                         description="Download in GB"
     *                     ),
     *                     @OA\Property(
     *                         property="GB_out",
     *                         type="number",
     *                         format="float",
     *                         description="Upload in GB"
     *                     )
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="selectedService",
     *                 type="string",
     *                 description="Selected service"
     *             ),
     *             @OA\Property(
     *                 property="selectedPeriod",
     *                 type="string",
     *                 description="Selected period"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client not found or has no services",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 description="Error message",
     *                 example="Client not found or has no services"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Selected service does not match Client",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 description="Error message",
     *                 example="Selected service does not match Client"
     *             )
     *         )
     *     ),
     *    @OA\Response(
     *         response=401,
     *         description="Unauthorized: API key is missing, invalid, or rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4002,
     *                 "message": "Invalid or inactive API key."
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Requests: Rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4003,
     *                 "message": "Too many requests. Please try again later."
     *             }
     *         )
     *     )
     * )
     */
    public function statistics(Request $request, $username)
    {
        // Find the client by their username and load their services
        $client = Client::with('services')->where('username', $username)->first();

        // Check if the client exists and has services
        if (!$client || $client->services->isEmpty()) {
            return response()->json(['error' => 'Client not found or has no services'], 404);
        }

        // Initialize total GB variables to 0
        $totalGBIn = 0;
        $totalGBOut = 0;
        $period = [];
        $selectedService = '';
        $selectedPeriod = 'monthly'; // Default value

        // Check if the client exists and has services
        if ($client && count($client->services) > 0) {
            // Get the selected service from the request or use the first service if not specified
            $selectedService = $request->input('interface', $client->services->first()->username);

            // Get the selected period from the request or default to monthly
            $selectedPeriod = 'monthly'; // Always set to 'monthly'

            // Find the selected service
            $service = $client->services->where('username', $selectedService)->first();

            // Check if the service exists and belongs to the client
            if (!$service || $service->user_id !== $client->id) {
                return response()->json(['error' => 'Selected service does not match Client ID'], 400);
            }

            if ($service) {
                $account = $service->username;

                $periodQuery = DB::table('data_usage_by_period')
                    ->select(DB::raw("DATE_FORMAT(data_usage_by_period.period_start, '%Y-%M') AS month"))
                    ->selectRaw("SUM(data_usage_by_period.acctinputoctets)/1000/1000/1000 AS GB_in")
                    ->selectRaw("SUM(data_usage_by_period.acctoutputoctets)/1000/1000/1000 AS GB_out")
                    ->leftJoin('data_usage_by_period AS subquery', function ($join) use ($account) {
                        $join->on('data_usage_by_period.period_start', '=', 'subquery.period_start')
                            ->where('subquery.username', $account)
                            ->whereNotNull('subquery.period_end');
                    })
                    ->where('data_usage_by_period.username', $account)
                    ->whereNotNull('data_usage_by_period.period_end')
                    ->whereYear('data_usage_by_period.period_start', '!=', 1970); // Exclude records with year 1970

                // Group by "monthly" period
                $periodQuery->groupBy(DB::raw('YEAR(data_usage_by_period.period_start), MONTH(data_usage_by_period.period_start), month'));

                $period = $periodQuery->get();

                $periodData = [];
                foreach ($period as $item) {
                    $periodData[] = [
                        'month' => $item->month,
                        'download' => $item->GB_out,
                        'upload' => $item->GB_in,
                    ];
                }

                // Calculate total data based on the selected period
                $subquery = DB::table('data_usage_by_period')
                    ->select(DB::raw("DATE_FORMAT(period_start, '%Y-%M') AS month"))
                    ->selectRaw("SUM(acctinputoctets)/1000/1000/1000 AS GB_in")
                    ->selectRaw("SUM(acctoutputoctets)/1000/1000/1000 AS GB_out")
                    ->where('username', $account)
                    ->whereNotNull('period_end');

                // Group by "monthly" period
                $subquery->groupBy(DB::raw('YEAR(period_start), MONTH(period_start), month'));

                $totalQuery = DB::table(DB::raw("({$subquery->toSql()}) as subquery"))
                    ->mergeBindings($subquery)
                    ->selectRaw('SUM(GB_in) AS total_GB_in')
                    ->selectRaw('SUM(GB_out) AS total_GB_out')
                    ->first();

                $totalGBIn = round($totalQuery->total_GB_in, 3);
                $totalGBOut = round($totalQuery->total_GB_out, 3);
            }
        }

        // Return the JSON response with the calculated statistics
        return response()->json([
            "client" => $client,
            "download" => $totalGBOut,
            "upload" => $totalGBIn,
            "period" => $periodData,
            "selectedService" => $selectedService,
            "selectedPeriod" => $selectedPeriod,
        ]);
    }


    /**
     * Get daily usage statistics for a specific service and month
     * 
     * Upon successful invocation of the endpoint, you receive an instance of the `service` details, together with thee `client`.
     * In addition, it retrieves daily usage `statistics` for the `service` and month. 
     * It provides information about the total `download` and `upload` data in gigabytes (`GB`) 
     * along with usage statistics for each `day` in the specified `month`. Authentication is required, and it expects a valid API key (`x-api-key`) to be included in the request header
     * Unauthorized requests are handled with a `401` response, and rate-limit exceeded scenarios are managed with a `429` response, each accompanied by appropriate error messages.
     * 
     * @OA\Get(
     *     path="/api/clients/statistics/daily",
     *     summary="Get daily usage statistics for a specific service and month",
     *     tags={"Clients"},
     *     operationId="viewStats",
     *     security={
     *         {"x-api-key": {}}
     *      },
     *      @OA\Parameter(
     *         name="x-api-key",
     *         in="header",
     *         required=true,
     *         description="API key is required. Example: 3fe15d2c7749b0f4e8d7211a33dbb28c2957e6678e4f472c9cde0836e9a912b7",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="service",
     *         in="query",
     *         required=true,
     *         description="Username of the service",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="month",
     *         in="query",
     *         required=true,
     *         description="Month and year in the format 'Year-Month' (e.g., '2023-October')",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *           @OA\Property(
     *            property="service",
     *            type="object",
     *            description="Detailed information about the service and its client",
     *            @OA\Property(property="id", type="integer", example=7),
     *            @OA\Property(property="user_id", type="integer", example=6),
     *            @OA\Property(property="package_id", type="integer", example=3),
     *            @OA\Property(property="nas_id", type="integer", example=1),
     *            @OA\Property(property="price", type="string", example="2000.00"),
     *            @OA\Property(property="username", type="string", example="john_doe"),
     *            @OA\Property(property="cleartextpassword", type="string", example="new_password"),
     *            @OA\Property(property="ipaddress", type="string", example="192.168.1.100"),
     *            @OA\Property(property="is_active", type="integer", example=1),
     *            @OA\Property(property="renewal", type="string", example=null),
     *            @OA\Property(property="expiry", type="string", example="2024-04-06T21:00:00.000000Z"),
     *            @OA\Property(property="description", type="string", example="Updated PPPoE service new one"),
     *            @OA\Property(property="grace_expiry", type="string", example=null),
     *            @OA\Property(property="deleted_at", type="string", example=null),
     *            @OA\Property(property="created_at", type="string", example="2024-04-05T23:29:35.000000Z"),
     *            @OA\Property(property="updated_at", type="string", example="2024-04-06T00:47:06.000000Z"),
     *            @OA\Property(property="mac_address", type="string", example=null),
     *            @OA\Property(property="type", type="string", example="PPP"),
     *            @OA\Property(property="info", type="string", example=null),
     *            @OA\Property(
     *                property="client",
     *                type="object",
     *                description="Client information",
     *                @OA\Property(property="id", type="integer", example=6),
     *                @OA\Property(property="firstname", type="string", example="John"),
     *                @OA\Property(property="lastname", type="string", example="Doe"),
     *                @OA\Property(property="username", type="string", example="574781"),
     *                @OA\Property(property="email", type="string", example="doe@mail.com"),
     *                @OA\Property(property="location", type="string", example=null),
     *                @OA\Property(property="latitude", type="string", example="10.2163179"),
     *                @OA\Property(property="longitude", type="string", example="36.7391117"),
     *                @OA\Property(property="phone", type="string", example=null),
     *                @OA\Property(property="category", type="string", example="individual"),
     *                @OA\Property(property="billingType", type="string", example="monthly"),
     *                @OA\Property(property="birthday", type="string", example=null),
     *                @OA\Property(property="identification", type="string", example=null),
     *                @OA\Property(property="avatar", type="string", example=null),
     *                @OA\Property(property="type", type="string", example="client"),
     *                @OA\Property(property="text_pass", type="string", example=null),
     *                @OA\Property(property="info", type="string", example=null),
     *                @OA\Property(property="email_verified_at", type="string", example=null),
     *                @OA\Property(property="created_at", type="string", example="2023-05-29T09:37:44.000000Z"),
     *                @OA\Property(property="updated_at", type="string", example="2024-03-29T18:09:15.000000Z")
     *               )
     *             ),
     *             @OA\Property(
     *                 property="download",
     *                 type="number",
     *                 format="float",
     *                 description="Total download in GB"
     *             ),
     *             @OA\Property(
     *                 property="upload",
     *                 type="number",
     *                 format="float",
     *                 description="Total upload in GB"
     *             ),
     *             @OA\Property(
     *                 property="period",
     *                 type="array",
     *                 description="Usage period",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="date",
     *                         type="string",
     *                         description="Date in 'Month Day, Year' format"
     *                     ),
     *                     @OA\Property(
     *                         property="Download",
     *                         type="number",
     *                         format="float",
     *                         description="Download in GB"
     *                     ),
     *                     @OA\Property(
     *                         property="Upload",
     *                         type="number",
     *                         format="float",
     *                         description="Upload in GB"
     *                     )
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="selectedService",
     *                 type="string",
     *                 description="Selected service"
     *             ),
     *             @OA\Property(
     *                 property="selectedMonthYear",
     *                 type="string",
     *                 description="Selected month and year"
     *             ),
     *             @OA\Property(
     *                 property="selectedPeriod",
     *                 type="string",
     *                 description="Selected period"
     *             )
     *         ),
     *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Bad request or invalid month-year format",
    *         @OA\JsonContent(
    *             @OA\Property(
    *                 property="error",
    *                 type="string",
    *                 description="Error message",
    *                 example="Invalid month-year format. Please use the format 'Month-Year' (e.g., '2023-October')"
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Service not found",
    *         @OA\JsonContent(
    *             @OA\Property(
    *                 property="error",
    *                 type="string",
    *                 description="Error message",
    *                 example="Service not found"
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Internal server error",
    *         @OA\JsonContent(
    *             @OA\Property(
    *                 property="error",
    *                 type="string",
    *                 description="Error message",
    *                 example="Internal server error occurred"
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Unauthorized: API key is missing, invalid, or rate limit exceeded",
    *         @OA\JsonContent(
    *             example={
    *                 "code": 4002,
    *                 "message": "Invalid or inactive API key."
    *             }
    *         )
    *     ),
    *     @OA\Response(
    *         response=429,
    *         description="Too Many Requests: Rate limit exceeded",
    *         @OA\JsonContent(
    *             example={
    *                 "code": 4003,
    *                 "message": "Too many requests. Please try again later."
    *             }
    *         )
    *     )
    * )
    */
    public function viewStats(Request $request)
    {
        // Retrieve the selected service, month, and year from the request
        $selectedService = $request->input('service');
        $selectedMonthYear = $request->input('month');

        // Retrieve the service or return an error if not found
        $service = Service::where('username', $selectedService)->first();
        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        // Retrieve the client associated with the service
        $client = $service->client;

        // Check if $selectedMonthYear contains a dash to separate year and month
        if (strpos($selectedMonthYear, '-') === false) {
            return response()->json(['error' => 'Invalid month-year format. Please use the format Month-Year eg 2023-October'], 400);
        }

        // Split the month-year string into separate variables for month and year
        list($selectedYear, $selectedMonth) = explode('-', $selectedMonthYear);

        // Define a mapping between month names and their corresponding numbers
        $monthToNumber = [
            'January' => 1, 'February' => 2, 'March' => 3, 'April' => 4,
            'May' => 5, 'June' => 6, 'July' => 7, 'August' => 8,
            'September' => 9, 'October' => 10, 'November' => 11, 'December' => 12,
        ];

        // Check if the selected month is valid
        if (!isset($monthToNumber[$selectedMonth])) {
            return response()->json(['error' => 'Invalid month. Please check the input data'], 400);
        }

        // Convert the selected month to its number representation
        $selectedMonthNumber = $monthToNumber[$selectedMonth];

        // Retrieve data for the selected month, grouped by date
        $dataByDate = DB::table('data_usage_by_period')
            ->select([
                DB::raw("DATE_FORMAT(period_start, '%Y-%m-%d') AS date"),
                DB::raw("SUM(acctinputoctets)/1000/1000/1000 AS GB_in"),
                DB::raw("SUM(acctoutputoctets)/1000/1000/1000 AS GB_out")
            ])
            ->where('username', $selectedService)
            ->whereNotNull('period_end')
            ->whereYear('period_start', $selectedYear)
            ->whereMonth('period_start', $selectedMonthNumber)
            ->groupBy(DB::raw('DATE_FORMAT(period_start, "%Y-%m-%d"), date'))
            ->get()
            ->map(function ($item) {
                // Format the date using Carbon
                $item->date = Carbon::createFromFormat('Y-m-d', $item->date)->format('M d, Y');
                return $item;
            });

        // Calculate the total data usage for the selected month
        $totalGBIn = round($dataByDate->sum('GB_in'), 3);
        $totalGBOut = round($dataByDate->sum('GB_out'), 3);

        // Transform dataByDate for consistency in naming convention
        $dataByDate->transform(function ($item) {
            $item->download = $item->GB_out;
            $item->upload = $item->GB_in;
            unset($item->GB_in, $item->GB_out); // Remove the original keys
            return $item;
        });

        // Return the data for the days in the selected month and the total as JSON response
        return response()->json([
            "service" => $service,
            "download" => $totalGBOut,
            "upload" => $totalGBIn,
            "period" => $dataByDate,
            "selectedService" => $selectedService,
            "selectedMonthYear" => $selectedMonthYear,
            "selectedPeriod" => 'daily',
        ]);
    }


    /**
     * Retrieve messages sent to a client
     * 
     * This endpoint retrieves `communication` details for a specified `client` in the system. Authentication is required, and it expects a valid API key (`x-api-key`) to be included in the request header. 
     * The client's `username` is provided as a path parameter to identify the client. Upon successful execution, a `200` response is returned, containing JSON data with information about the client, their messages, and available templates. 
     * If the specified client is not found, a `404` response is returned. Unauthorized requests are handled with a `401` response, and rate-limit exceeded scenarios are managed with a `429` response, each accompanied by appropriate error messages.
     * 
     * @OA\Get(
     *     path="/api/clients/{username}/communication",
     *     summary="Get client communication details",
     *     tags={"Clients"},
     *     operationId="GetClientCommunication",
     *     security={
     *         {"x-api-key": {}}
     *      },
     *      @OA\Parameter(
     *         name="x-api-key",
     *         in="header",
     *         required=true,
     *         description="API key is required. Example: 3fe15d2c7749b0f4e8d7211a33dbb28c2957e6678e4f472c9cde0836e9a912b7",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="Username of the client",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success response",
     *         @OA\JsonContent(
     *             @OA\Property(property="client", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", format="int64"),
     *                 @OA\Property(property="firstname", type="string"),
     *                 @OA\Property(property="lastname", type="string"),
     *                 @OA\Property(property="username", type="string"),
     *                 @OA\Property(property="email", type="string", format="email"),
     *                 @OA\Property(property="location", type="string"),
     *                 @OA\Property(property="latitude", type="string"),
     *                 @OA\Property(property="longitude", type="string"),
     *                 @OA\Property(property="phone", type="string"),
     *                 @OA\Property(property="category", type="string"),
     *                 @OA\Property(property="billingType", type="string"),
     *                 @OA\Property(property="birthday", type="string", format="date"),
     *                 @OA\Property(property="identification", type="string"),
     *                 @OA\Property(property="avatar", type="string"),
     *                 @OA\Property(property="text_pass", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )),
     *             @OA\Property(property="messages", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="sender", type="string"),
     *                 @OA\Property(property="message", type="string"),
     *                 @OA\Property(property="gateway", type="string"),
     *                 @OA\Property(property="messageId", type="string"),
     *                 @OA\Property(property="status", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )),
     *             @OA\Property(property="templates", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="type", type="string"),
     *                 @OA\Property(property="content", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Client not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Client not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized: API key is missing, invalid, or rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4002,
     *                 "message": "Invalid or inactive API key."
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Requests: Rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4003,
     *                 "message": "Too many requests. Please try again later."
     *             }
     *         )
     *     )
     * )
     */
    public function communication($username): JsonResponse
    {
        try {
            $client = Client::where('username', $username)->first();

            $messages = $client->messages;
            $templates = Template::where('type', 'sms')->get();

            return response()->json([
                'client' => $client,
                'messages' => $messages,
                'templates' => $templates,
            ]);
        } catch (\Exception $e) {
            // Log or handle the exception
            Log::error('Error fetching communication details: ' . $e->getMessage());
            return response()->json(['error' => 'Client not found'], 404);
        }
    }

    /**
     * Send message to a client
     * 
     * This POST endpoint serves the purpose of facilitating the sending of messages to clients within the system. 
     * Upon invocation, the endpoint requires the inclusion of a valid API key (`x-api-key`) in the request `header` for authentication. 
     * It expects the client's `username` to be provided as a path parameter. The request body, formatted as `JSON`, must contain the message to be sent, with the `message` property being `mandatory`. 
     * Upon successful execution, a `200` response signifies that the message was delivered successfully. 
     * However, various error responses are also defined to handle scenarios such as validation failures, client not found, or internal server issues. 
     * Functionally, the endpoint verifies if SMS messaging is enabled and if the configured SMS gateway is operational before attempting message delivery. 
     * Overall, this endpoint provides a structured and secure means of communication with clients.
     * 
     * @OA\Post(
     *     path="/api/clients/{username}/send-message",
     *     summary="Send a message to a client",
     *     tags={"Clients"},
     *     operationId="SendClientMessage",
     *     security={
     *         {"x-api-key": {}}
     *      },
     *      @OA\Parameter(
     *         name="x-api-key",
     *         in="header",
     *         required=true,
     *         description="API key is required. Example: 3fe15d2c7749b0f4e8d7211a33dbb28c2957e6678e4f472c9cde0836e9a912b7",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="Username of the client",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"message"},
     *             @OA\Property(property="message", type="string", example="Your message here")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success response",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="string", example="Message sent successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Validation failed")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Client not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Client not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to send Message. Kindly make sure the SMS gateway is configured correctly")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized: API key is missing, invalid, or rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4002,
     *                 "message": "Invalid or inactive API key."
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Requests: Rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4003,
     *                 "message": "Too many requests. Please try again later."
     *             }
     *         )
     *     )
     * )
     */
    public function client_simple_send(Request $request, $username)
    {
        try {
            $data = $request->validate(['message' => 'required']);

            $client = Client::where('username', $username)->first();
            if (!$client) {
                return response()->json(['error' => 'Client not found'], 404);
            }

            if (setting('sms') !== 'enabled') {
                return response()->json(['error' => 'SMS messaging is not enabled'], 400);
            }

            $gateway = setting('smsgateway');
            if (!$gateway) {
                return response()->json(['error' => 'SMS gateway is not configured'], 400);
            }
            $gatewaySender = setting("$gateway" . '_sender_id');
            $gatewayName = setting("$gateway" . '_gateway');

            if (strpos($data['message'], '{{ $service_name }}') !== false || strpos($data['message'], '{{ $service_price }}') !== false) {
                // Retrieve all client services
                $clientServices = $client->services;

                foreach ($clientServices as $service) {
                    // Replace placeholders with actual values in the message
                    $result = sendSms($client->phone, message($client, $data['message'], $service));
                    if ($result['status'] == 'error') {
                        return response()->json(['error' => 'Failed to send Message. Kindly make sure the SMS gateway is configured correctly'], 500);
                    }        

                    // Create a message record for each service
                    Message::create([
                        'user_id' => $client->id,
                        'sender' => $gatewaySender,
                        'message' => message($client, $data['message'], $service),
                        'gateway' => $gatewayName,
                        'status' => 'Sent',
                    ]);
                }
            } else {
                // If no placeholders, send the original message
                $result = sendSms($client->phone, message($client, $data['message']));
                if ($result['status'] == 'error') {
                    return response()->json(['error' => 'Failed to send Message. Kindly make sure the SMS gateway is configured correctly'], 500);
                }

                Message::create([
                    'user_id' => $client->id,
                    'sender' => $gatewaySender,
                    'message' => message($client, $data['message']),
                    'gateway' => $gatewayName,
                    'status' => 'Sent',
                ]);
            }

            return response()->json(['success' => 'Message sent successfully']);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send message: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Delete a client from the system
     * 
     * This DELETE endpoint enables the removal of a specified client from the system. 
     * A valid API key (`x-api-key`) must be included in the request header for authentication. 
     * The client's `username`, provided as a post parameter, identifies the `client` to be deleted. 
     * The endpoint returns a `200` response upon successful deletion, with a message indicating the successful deletion of the client. 
     * In cases where the client cannot be deleted due to associated services, a `400` response is returned along with an error message specifying the reason. 
     * Additionally, a `404` response is returned if the specified client is not found. The endpoint also handles unauthorized requests with a `401` response and rate-limit exceeded scenarios with a `429` response, providing appropriate error messages for each case.
     * 
     * @OA\Delete(
     *     path="/api/clients/delete",
     *     summary="Delete the specified client from the system",
     *     tags={"Clients"},
     *     operationId="Delete Client",
     *     security={
     *         {"x-api-key": {}}
     *      },
     *      @OA\Parameter(
     *         name="x-api-key",
     *         in="header",
     *         required=true,
     *         description="API key is required. Example: 3fe15d2c7749b0f4e8d7211a33dbb28c2957e6678e4f472c9cde0836e9a912b7",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="The username of the client to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Client deleted successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Cannot delete client because they have associated services",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Cannot delete client because they have associated services"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="client not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="client not found"
     *             )
     *         )
     *     ),
     *    @OA\Response(
     *         response=401,
     *         description="Unauthorized: API key is missing, invalid, or rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4002,
     *                 "message": "Invalid or inactive API key."
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Requests: Rate limit exceeded",
     *         @OA\JsonContent(
     *             example={
     *                 "code": 4003,
     *                 "message": "Too many requests. Please try again later."
     *             }
     *         )
     *     )
     * )
     */
    public function destroy(Request $request)
    {
        $username = $request->username;
        // Search for the client by username
        $client = Client::where('username', $username)->first();

        // Check if the client exists
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }
        
        // Check if the client has associated services
        if ($client->services()->exists()) {
            // If the client has services, return an error response
            return response()->json(['error' => 'Cannot delete client because they have associated services'], 400);
        }

        // Delete the client
        $client->delete();

        // Log the deletion activity
        activity()
            ->performedOn($client)
            ->withProperties(['action' => 'deleted'])
            ->log('Deleted client ' . $client->username);

        // Return success response
        return response()->json(['message' => 'Client deleted successfully'], 200);
    }

}
