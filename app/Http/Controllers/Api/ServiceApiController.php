<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Package;
use App\Models\Service;
use App\Models\Nas;
use App\Jobs\ServiceJob;
use Spatie\Tags\Tag;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Jobs\BlockUserJob;
use App\Jobs\UnblockUserJob;
use App\Jobs\DisconnectServiceJob;
use Exception;

class ServiceApiController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/services/client/{username}/save-pppoe-service",
     *     summary="Create new PPPoE service for a client",
     *     description="This endpoint allows users to save DHCP service information for a client. Ensure to pass the ID of the `NAS` and the ID of the `package`. If you do not want to bill the `installationFee`, make sure to remove that field from the input. If you dont include the `price` input, the user is automatically assigned the price of the selected package. A valid API key (`x-api-key`) must be included in the request `header` for authentication. ",
     *     tags={"Services"},
     *     operationId="savePPPoEService",
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
     *         description="PPPoE service data to be saved",
     *         @OA\JsonContent(
     *             required={"package", "nas", "username", "password", "ipaddress"},
     *             @OA\Property(property="package", type="integer", description="ID of the package"),
     *             @OA\Property(property="price", type="integer", description="Price of the service"),
     *             @OA\Property(property="nas", type="integer", description="ID of the NAS"),
     *             @OA\Property(property="ipaddress", type="string", description="IP address"),
     *             @OA\Property(property="username", type="string", description="Username"),
     *             @OA\Property(property="password", type="string", description="Password"),
     *             @OA\Property(property="description", type="string", description="Description of the service"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string"), description="List of tags"),
     *             @OA\Property(property="installationFee", type="integer", description="Installation fee")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Service saved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success", description="Status of the operation"),
     *             @OA\Property(property="message", type="string", example="PPPoE service added successfully", description="Success message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request or Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error", description="Status of the operation"),
     *             @OA\Property(property="message", type="string", example="Validation error", description="Error message"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 description="Validation errors",
     *                 @OA\Property(property="ipaddress", type="array", @OA\Items(type="string"), example={"The ipaddress must be a valid IP address."}),
     *                 @OA\Property(property="username", type="array", @OA\Items(type="string"), example={"The username has already been taken."}),
     *                 @OA\Property(property="password", type="array", @OA\Items(type="string"), example={"The password field is required."})
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client or package not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error", description="Status of the operation"),
     *             @OA\Property(property="message", type="string", example="Client or package not found", description="Error message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error", description="Status of the operation"),
     *             @OA\Property(property="message", type="string", example="Internal server error occurred", description="Error message")
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
     */
    public function savePPPoEService(Request $request, $username)
    {
        try {
            $data = $this->validatePPPoEServiceRequest($request);

            // Check if manualIpAddress is set and use it as ipaddress
            if (isset($data["manualIpAddress"])) {
                $data["ipaddress"] = $data["manualIpAddress"];
                unset($data["manualIpAddress"]); // Optional: Remove manualIpAddress if you want
            }

            checkLicenseType();

            $client = Client::where("username", $username)->first();
            if (!$client) {
                return response()->json(
                    [
                        "status" => "error",
                        "message" => "Client not found",
                    ],
                    404
                );
            }

            $package = Package::find($request->package);
            if (!$package) {
                return response()->json(
                    [
                        "status" => "error",
                        "message" => "Package not found",
                    ],
                    404
                );
            }

            $nas = Nas::find($request->nas);
            if (!$nas) {
                return response()->json(
                    [
                        "status" => "error",
                        "message" => "NAS not found",
                    ],
                    404
                );
            }

            DB::beginTransaction();

            try {
                $service = $this->insertRadCheckAndRadReplyForPPPoE(
                    $request,
                    $data,
                    $package,
                    $client
                );

                if ($service instanceof \Exception) {
                    // Service creation failed
                    return response()->json(
                        [
                            "status" => "error",
                            "message" => $service->getMessage(), // Return the exception message
                        ],
                        500
                    );
                }

                if ($request->nas) {
                    $nas = Nas::find($request->nas);
                    $service
                        ->nas()
                        ->associate($nas)
                        ->save();
                }

                // Sync tags with the service.
                if (!empty($request->tags)) {
                    $tags = collect($request->tags)->map(function ($tagName) {
                        return Tag::findOrCreateFromString($tagName);
                    });

                    $service->syncTags($tags);
                }

                // Generate invoice if installation fee is added
                if ($request->filled("installationFee")) {
                    installationInvoice($client, $data["installationFee"]);
                }

                // Service creation succeeded
                DB::commit();

                return response()->json(
                    [
                        "status" => "success",
                        "message" => "PPPoE service added successfully",
                        "service" => $service, // You may adjust this based on what data you want to return
                    ],
                    200
                );
            } catch (Exception $e) {
                DB::rollBack();

                logger()->error($e);

                return response()->json(
                    [
                        "status" => "error",
                        "message" => $e->getMessage(),
                    ],
                    500
                );
            }
        } catch (ValidationException $e) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => "Validation error",
                    "errors" => $e->validator->errors()->toArray(),
                ],
                422
            );
        }
    }

    private function validatePPPoEServiceRequest(Request $request)
    {
        $rules = [
            "username" => ["required", "unique:services,username"],
            "password" => ["required"],
            "nas" => ["required"],
            "ipaddress" => ["required", "unique:services,ipaddress", "ip"],
            "package" => ["required"],
            "installationFee" => ["nullable", "numeric", "min:0"],
            "description" => ["nullable", "string"],
        ];

        return $request->validate($rules);
    }

    private function insertRadCheckAndRadReplyForPPPoE(
        Request $request,
        array $data,
        Package $package,
        Client $client
    ) {
        try {
            // Insert data into radcheck and radreply tables
            DB::table("radcheck")->insert([
                [
                    "username" => $data["username"],
                    "attribute" => "Cleartext-Password",
                    "op" => ":=",
                    "value" => $data["password"],
                ],
                [
                    "username" => $data["username"],
                    "attribute" => "User-Profile",
                    "op" => ":=",
                    "value" => $package->name,
                ],
            ]);

            DB::table("radreply")->insert([
                "username" => $data["username"],
                "attribute" => "Framed-IP-Address",
                "op" => ":=",
                "value" => $data["ipaddress"],
            ]);

            // Create a new service for the client
            return $client->services()->create([
                "username" => $data["username"],
                "cleartextpassword" => $data["password"],
                "ipaddress" => $data["ipaddress"],
                "package_id" => $package->id,
                "nas_id" => $request->input("nas"),
                "price" => $request->input("price", $package->price),
                "is_active" => 1,
                "expiry" => now()
                    ->addDay()
                    ->format("Y-m-d"),
                "description" => $data["description"],
                "type" => "PPP",
            ]);
        } catch (\Exception $e) {
            logger()->error($e);
            return new \Exception(
                "Failed to create service: " . $e->getMessage()
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/services/client/{username}/save-dhcp-service",
     *     summary="Create new DHCP service for a client",
     *     description="This endpoint allows users to save DHCP service information for a client. Ensure to pass the ID of the `NAS` and the ID of the `package`. If you do not want to bill the `installationFee`, make sure to remove that field from the input. If you dont include the `price` input, the user is automatically assigned the price of the selected package. A valid API key (`x-api-key`) must be included in the request `header` for authentication. ",
     *     tags={"Services"},
     *     operationId="saveDHCPService",
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
     *         description="Username of the Service",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="DHCP service data to be saved",
     *         @OA\JsonContent(
     *             required={"package", "nas", "macaddress", "ipaddress"},
     *             @OA\Property(property="package", type="integer", description="ID of the package"),
     *             @OA\Property(property="price", type="integer", description="Price of the service"),
     *             @OA\Property(property="nas", type="integer", description="ID of the NAS"),
     *             @OA\Property(property="ipaddress", type="string", description="IP address"),
     *             @OA\Property(property="macaddress", type="string", description="MAC address"),
     *             @OA\Property(property="description", type="string", description="Description of the service"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string"), description="List of tags"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Service saved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success", description="Status of the operation"),
     *             @OA\Property(property="message", type="string", example="DHCP service added successfully", description="Success message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request or Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error", description="Status of the operation"),
     *             @OA\Property(property="message", type="string", example="Validation error", description="Error message"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 description="Validation errors",
     *                 @OA\Property(property="ipaddress", type="array", @OA\Items(type="string"), example={"The ipaddress must be a valid IP address."}),
     *                 @OA\Property(property="macaddress", type="array", @OA\Items(type="string"), example={"The macaddress has already been taken."})
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client or package not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error", description="Status of the operation"),
     *             @OA\Property(property="message", type="string", example="Client or package not found", description="Error message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error", description="Status of the operation"),
     *             @OA\Property(property="message", type="string", example="Internal server error occurred", description="Error message")
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
     */
    public function saveDHCPService(Request $request, $username)
    {
        try {
            $data = $this->validateDHCPServerRequest($request);

            checkLicenseType();

            $client = Client::where("username", $username)->first();
            if (!$client) {
                return response()->json(
                    [
                        "status" => "error",
                        "message" => "Client not found",
                    ],
                    404
                );
            }

            $package = Package::find($request->package);
            if (!$package) {
                return response()->json(
                    [
                        "status" => "error",
                        "message" => "Package not found",
                    ],
                    404
                );
            }

            $nas = Nas::find($request->nas);
            if (!$nas) {
                return response()->json(
                    [
                        "status" => "error",
                        "message" => "NAS not found",
                    ],
                    404
                );
            }

            DB::beginTransaction();

            try {
                $service = $this->insertRadCheckAndRadReplyForDHCP(
                    $request,
                    $data,
                    $package,
                    $client
                );

                if ($service instanceof \Exception) {
                    // Service creation failed
                    return response()->json(
                        [
                            "status" => "error",
                            "message" => $service->getMessage(), // Return the exception message
                        ],
                        500
                    );
                }

                if ($request->nas) {
                    $nas = Nas::find($request->nas);
                    $service
                        ->nas()
                        ->associate($nas)
                        ->save();
                }

                // Sync tags with the service.
                if (!empty($request->tags)) {
                    $tags = collect($request->tags)->map(function ($tagName) {
                        return Tag::findOrCreateFromString($tagName);
                    });

                    $service->syncTags($tags);
                }

                // Generate invoice if installation fee is added
                if ($request->filled("installationFee")) {
                    installationInvoice($client, $data["installationFee"]);
                }

                // Service creation succeeded
                DB::commit();

                return response()->json(
                    [
                        "status" => "success",
                        "message" => "DHCP service added successfully",
                        "service" => $service, // You may adjust this based on what data you want to return
                    ],
                    200
                );
            } catch (Exception $e) {
                DB::rollBack();

                logger()->error($e);

                return response()->json(
                    [
                        "status" => "error",
                        "message" => $e->getMessage(),
                    ],
                    500
                );
            }
        } catch (ValidationException $e) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => "Validation error",
                    "errors" => $e->validator->errors()->toArray(),
                ],
                422
            );
        }
    }

    private function validateDHCPServerRequest(Request $request)
    {
        $rules = [
            "package" => ["required"],
            "nas" => ["required"],
            "ipaddress" => request("manualIpAddress")
                ? []
                : ["required", "unique:services,ipaddress", "ip"],
            "macaddress" => ["required", "unique:services,mac_address"],
            "installationFee" => ["nullable", "numeric", "min:0"],
            "description" => ["nullable", "string"],
        ];

        return $request->validate($rules);
    }

    private function insertRadCheckAndRadReplyForDHCP(
        Request $request,
        array $data,
        Package $package,
        Client $client
    ) {
        try {
            // Insert data into radcheck and radreply tables
            DB::table("radcheck")->insert([
                [
                    "username" => $data["macaddress"],
                    "attribute" => "Auth-Type",
                    "op" => ":=",
                    "value" => "Accept",
                ],
                [
                    "username" => $data["macaddress"],
                    "attribute" => "User-Profile",
                    "op" => ":=",
                    "value" => $package->name,
                ],
            ]);

            DB::table("radreply")->insert([
                "username" => $data["macaddress"],
                "attribute" => "Framed-IP-Address",
                "op" => ":=",
                "value" => $data["ipaddress"],
            ]);

            // Create a new service for the client
            return $client->services()->create([
                "username" => $data["macaddress"],
                "mac_address" => $data["macaddress"],
                "ipaddress" => $data["ipaddress"],
                "package_id" => $package->id,
                "nas_id" => $request->input("nas"),
                "price" => $request->input("price", $package->price),
                "is_active" => 1,
                "expiry" => now()
                    ->addDay()
                    ->format("Y-m-d"),
                "description" => $data["description"],
                "type" => "DHCP",
            ]);
        } catch (\Exception $e) {
            logger()->error($e);
            return new \Exception(
                "Failed to create service: " . $e->getMessage()
            );
        }
    }

    /**
     * @OA\Put(
     *      path="/api/services/{username}/update-pppoe-service",
     *      operationId="updatePPPoEService",
     *      tags={"Services"},
     *      summary="Update PPPoE service for a client",
     *      description="Update PPPoE service details for a client. Ensure to pass the ID of the `NAS` and the ID of the `package`. If you dont include the `price` input, the user is automatically assigned the price of the selected package. A valid API key (`x-api-key`) must be included in the request `header` for authentication. ",
     *      operationId="updatePppoeService",
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
     *      @OA\Parameter(
     *          name="username",
     *          description="Service username",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Updated PPPoE service data",
     *          @OA\JsonContent(
     *              required={"package", "nas", "username", "password", "ipaddress"},
     *             @OA\Property(property="package", type="integer", description="ID of the package"),
     *             @OA\Property(property="price", type="integer", description="Price of the service"),
     *             @OA\Property(property="nas", type="integer", description="ID of the NAS"),
     *             @OA\Property(property="ipaddress", type="string", description="IP address"),
     *             @OA\Property(property="username", type="string", description="Username"),
     *             @OA\Property(property="password", type="string", description="Password"),
     *             @OA\Property(property="description", type="string", description="Description of the service"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string"), description="List of tags"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Service not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="Service not found"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="Internal Server Error"),
     *          )
     *      ),
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
     */

    public function updatePPPoEService(Request $request, $username)
    {
        try {
            // Find the service by username
            $service = Service::where("username", $username)->first();
            if (!$service || $service->type !== "PPP") {
                return response()->json(
                    [
                        "status" => "error",
                        "message" =>
                            "Service not avilable or its not a PPP service",
                    ],
                    404
                );
            }

            // Validate the request
            $data = $this->validateUpdatePPPoEServiceRequest(
                $request,
                $service
            );

            // Retrieve package and NAS
            $package = Package::find($request->package);
            if (!$package) {
                return response()->json(
                    [
                        "status" => "error",
                        "message" => "Package not found",
                    ],
                    404
                );
            }

            $nas = Nas::find($request->nas);
            if (!$nas) {
                return response()->json(
                    [
                        "status" => "error",
                        "message" => "NAS not found",
                    ],
                    404
                );
            }

            // Begin transaction
            DB::beginTransaction();

            try {
                // Update the service and related records
                $updatedService = $this->updateRadCheckAndRadReplyForPPPoE(
                    $request,
                    $data,
                    $package,
                    $service
                );
                if ($updatedService instanceof \Exception) {
                    DB::rollBack();
                    return response()->json(
                        [
                            "status" => "error",
                            "message" => $updatedService->getMessage(), // Return the exception message
                        ],
                        500
                    );
                }

                // Sync tags with the service.
                if (!empty($request->tags)) {
                    $tags = collect($request->tags)->map(function ($tagName) {
                        return Tag::findOrCreateFromString($tagName);
                    });

                    $updatedService->syncTags($tags);
                }

                refresh_address($nas->nasname);

                // Service update succeeded
                DB::commit();

                return response()->json(
                    [
                        "status" => "success",
                        "message" => "PPPoE service updated successfully",
                        "service" => $updatedService,
                    ],
                    200
                );
            } catch (Exception $e) {
                DB::rollBack();

                logger()->error($e);

                return response()->json(
                    [
                        "status" => "error",
                        "message" => $e->getMessage(),
                    ],
                    500
                );
            }
        } catch (ValidationException $e) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => "Validation error",
                    "errors" => $e->validator->errors()->toArray(),
                ],
                422
            );
        }
    }

    public function validateUpdatePPPoEServiceRequest(
        Request $request,
        $service
    ) {
        $rules = [
            "username" => [
                "required",
                "unique:services,username," . $service->id,
            ],
            "password" => ["required"],
            "nas" => ["required"],
            "ipaddress" => [
                "ip",
                "required",
                "unique:services,ipaddress," . $service->id,
            ],
            "package" => ["required"],
            "description" => ["nullable", "string"],
        ];

        return $request->validate($rules);
    }

    private function updateRadCheckAndRadReplyForPPPoE(
        Request $request,
        array $data,
        Package $package,
        Service $service
    ) {
        try {
            $username = $service->username;

            // Common update for radcheck
            $updateRadcheck = [
                "username" => $data["username"],
            ];

            // Update radcheck table
            $updateAttributes = [
                "Cleartext-Password" => $data["password"],
                "Auth-Type" => "Accept",
                "User-Profile" => $package->name,
            ];

            foreach ($updateAttributes as $attribute => $value) {
                DB::table("radcheck")
                    ->where("username", $username)
                    ->where("attribute", $attribute)
                    ->update(
                        array_filter(["value" => $value] + $updateRadcheck)
                    );
            }

            // Update radreply table
            DB::table("radreply")
                ->where("username", $username)
                ->where("attribute", "Framed-IP-Address")
                ->update([
                    "username" => $data["username"],
                    "value" => $data["ipaddress"],
                ]);

            // Update the service details
            $service->update([
                "username" => $data["username"],
                "cleartextpassword" => $data["password"],
                "ipaddress" => $data["ipaddress"],
                "package_id" => $package->id,
                "price" => $request->input("price", $package->price),
                "description" => $data["description"],
            ]);

            return $service;
        } catch (\Exception $e) {
            logger()->error($e);
            return new \Exception(
                "Failed to update service: " . $e->getMessage()
            );
        }
    }

    /**
     * @OA\Put(
     *      path="/api/services/{username}/update-dhcp-service",
     *      operationId="updateDHCPService",
     *      tags={"Services"},
     *      summary="Update DHCP service for a client",
     *      description="Update DHCP service details for a client. Ensure to pass the ID of the `NAS` and the ID of the `package`. If you dont include the `price` input, the user is automatically assigned the price of the selected package. A valid API key (`x-api-key`) must be included in the request `header` for authentication.",
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
     *      @OA\Parameter(
     *          name="username",
     *          description="Service username",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Updated DHCP service data",
     *          @OA\JsonContent(
     *              required={"package", "nas", "macaddress", "ipaddress"},
     *             @OA\Property(property="package", type="integer", description="ID of the package"),
     *             @OA\Property(property="price", type="integer", description="Price of the service"),
     *             @OA\Property(property="nas", type="integer", description="ID of the NAS"),
     *             @OA\Property(property="ipaddress", type="string", description="IP address"),
     *             @OA\Property(property="macaddress", type="string", description="MAC address"),
     *             @OA\Property(property="description", type="string", description="Description of the service"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string"), description="List of tags"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Client, DHCP service, Package, or NAS not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="Client, DHCP service, Package, or NAS not found"),
     *          )
     *      ),
     *      @OA\Response(
     *      response=422,
     *      description="Validation error",
     *      @OA\JsonContent(
     *          @OA\Property(property="status", type="string", example="error"),
     *          @OA\Property(property="message", type="string", example="Validation error"),
     *          @OA\Property(property="errors", type="object",
     *              @OA\Property(property="package", type="array",
     *                  @OA\Items(type="string", example="The package field is required.")
     *              )
     *          ),
     *      )
     * ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="Internal Server Error"),
     *          )
     *      ),
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
     */

    public function updateDHCPService(Request $request, $username)
    {
        try {
            checkLicenseType();

            // Find the client
            $service = Service::where("username", $username)->first();
            if (!$service || $service->type !== "DHCP") {
                return response()->json(
                    [
                        "status" => "error",
                        "message" => "Service not found or not of type",
                    ],
                    404
                );
            }

            // Find the package and NAS
            $package = Package::find($request->package);
            if (!$package) {
                return response()->json(
                    [
                        "status" => "error",
                        "message" => "Package not found",
                    ],
                    404
                );
            }

            $nas = Nas::find($request->nas);
            if (!$nas) {
                return response()->json(
                    [
                        "status" => "error",
                        "message" => "NAS not found",
                    ],
                    404
                );
            }

            $data = $this->validateDHCPServerUpdateRequest($request, $service);

            DB::beginTransaction();

            try {
                // Update the DHCP service
                $updatedService = $this->updateRadCheckAndRadReplyForDHCP($request,$data,$package,$service);

                // Update NAS if provided
                if ($request->nas) {
                    $service
                        ->nas()
                        ->associate($nas)
                        ->save();
                }

                // Sync tags with the service.
                if (!empty($request->tags)) {
                    $tags = collect($request->tags)->map(function ($tagName) {
                        return Tag::findOrCreateFromString($tagName);
                    });

                    $updatedService->syncTags($tags);
                }

                refresh_address($nas->nasname);

                // Service update succeeded
                DB::commit();

                return response()->json(
                    [
                        "status" => "success",
                        "message" => "DHCP service updated successfully",
                        "service" => $updatedService,
                    ],
                    200
                );
            } catch (Exception $e) {
                DB::rollBack();

                logger()->error($e);

                return response()->json(
                    [
                        "status" => "error",
                        "message" => $e->getMessage(),
                    ],
                    500
                );
            }
        } catch (ValidationException $e) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => "Validation error",
                    "errors" => $e->validator->errors()->toArray(),
                ],
                422
            );
        }
    }

    private function validateDHCPServerUpdateRequest(Request $request, $service)
    {
        $rules = [
            "package" => ["required"],
            "nas" => ["required"],
            "ipaddress" => [
                "ip",
                "required",
                "unique:services,ipaddress," . $service->id,
            ],
            "macaddress" => ["required", "unique:services,mac_address"],
            "description" => ["nullable", "string"],
        ];

        return $request->validate($rules);
    }

    private function updateRadCheckAndRadReplyForDHCP(Request $request, array $data, Package $package, Service $service) {
        try {
            // Update data into radcheck and radreply tables
            $username = $service->username;

            // Common update for radcheck
            $updateRadcheck = [
                "username" => $data["username"],
            ];

            // Update radcheck table
            $updateAttributes = [
                "Auth-Type" => "Accept",
                "User-Profile" => $package->name,
            ];

            foreach ($updateAttributes as $attribute => $value) {
                DB::table("radcheck")
                    ->where("username", $username)
                    ->where("attribute", $attribute)
                    ->update(
                        array_filter(["value" => $value] + $updateRadcheck)
                    );
            }

            // Update radreply table
            DB::table("radreply")
                ->where("username", $username)
                ->where("attribute", "Framed-IP-Address")
                ->update([
                    "username" => $data["username"],
                    "value" => $data["ipaddress"],
                ]);

            // Update the service details
            $service->update([
                "username" => $data["username"],
                "ipaddress" => $data["ipaddress"],
                "package_id" => $package->id,
                "price" => $request->input("price", $package->price),
                "description" => $data["description"],
                "mac_address" => $data["username"],
            ]);

            return $service;
        } catch (\Exception $e) {
            logger()->error($e);
            return new \Exception(
                "Failed to update service: " . $e->getMessage()
            );
        }
    }

    /**
     * @OA\Get(
     *     path="/api/services/client/{username}",
     *     summary="Retrieve Client Services",
     *     description="This GET endpoint serves the purpose of retrieving all services associated with a specific `Client`, identified by their unique username. The `username` represents the username of the `client` whose services are to be retrieved. A valid API key (`x-api-key`) must be included in the request `header` for authentication. Upon successful authentication, the endpoint returns a JSON response containing details of the user's services. The response includes a status indicator to signify the success of the operation, denoted by `success`. Accompanying the status indicator is an array of service objects encapsulating information about each service associated with the specified user. In the event that the requested user is not found in the system, a `404` response is returned, along with an error message indicating the absence of the user. Additionally, robust error handling mechanisms are implemented to handle unauthorized access attempts or scenarios where the rate limit for requests is exceeded. In such cases, appropriate error responses are returned,",
     *     tags={"Services"},
     *     operationId="getUserServices",
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
     *         description="User services retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success", description="Status of the operation"),
     *             @OA\Property(
     *                 property="services",
     *                 type="array",
     *                 @OA\Items(type="object", description="User service data"),
     *                 description="List of user services"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error", description="Status of the operation"),
     *             @OA\Property(property="message", type="string", example="User not found", description="Error message")
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
     */
    public function getUserServices($username)
    {
        // Retrieve the user based on the username
        $user = Client::where("username", $username)->first();

        if (!$user) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => "User not found",
                ],
                404
            );
        }

        // Retrieve the user's services
        $services = $user->services;

        return response()->json([
            "status" => "success",
            "services" => $services,
        ]);
    }

    /**
     * @param string $username Username of the service
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/services/{username}/details",
     *     summary="Retrieve Service Details by Username",
     *     description="This GET endpoint facilitates the retrieval of detailed information regarding a specific `service` identified by its unique `username`. A valid API key (`x-api-key`) must be included in the request `header` for authentication. Upon successful authentication, the endpoint returns comprehensive details of the service associated with the provided username. A `200` response indicate successful operation completion, while a `404` response signifies that the service was not found. In case of an internal server error, a `500` response is returned. ",
     *     tags={"Services"},
     *     operationId="getServiceDetailsByUsername",
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
     *         description="Username of the service",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Service details retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success", description="Status of the operation"),
     *             @OA\Property(
     *                 property="service",
     *                 type="object",
     *                 description="Service details",
     *                 @OA\Property(property="id", type="integer", example=71, description="Service ID"),
     *                 @OA\Property(property="user_id", type="integer", example=4, description="User ID"),
     *                 @OA\Property(property="package_id", type="integer", example=3, description="Package ID"),
     *                 @OA\Property(property="nas_id", type="integer", example=1, description="NAS ID"),
     *                 @OA\Property(property="price", type="string", example="2000.00", description="Price of the service"),
     *                 @OA\Property(property="username", type="string", example="kelvin", description="Username of the service"),
     *                 @OA\Property(property="password", type="string", example="murithi", description="Password of the service"),
     *                 @OA\Property(property="ip_address", type="string", example="10.10.3.5", description="IP address assigned to the service"),
     *                 @OA\Property(property="status", type="string", example="active", description="Status of the service"),
     *                 @OA\Property(property="expiry", type="string", example="2024-04-05T21:00:00.000000Z", description="Expiry date of the service"),
     *                 @OA\Property(property="description", type="string", example="Home internet", description="Description of the service"),
     *                 @OA\Property(property="grace_expiry", type="string", example=null, description="Grace expiry of the service"),
     *                 @OA\Property(property="mac_address", type="string", example=null, description="MAC address associated with the service"),
     *                 @OA\Property(property="type", type="string", example="PPPOE", description="Type of the service"),
     *                 @OA\Property(property="info", type="string", example=null, description="Additional information about the service"),
     *                 @OA\Property(property="deleted_at", type="string", example=null, description="Deletion timestamp of the service"),
     *                 @OA\Property(property="created_at", type="string", example="2024-04-05T14:08:42.000000Z", description="Creation timestamp of the service"),
     *                 @OA\Property(property="updated_at", type="string", example="2024-04-05T14:08:42.000000Z", description="Last update timestamp of the service")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error", description="Status of the operation"),
     *             @OA\Property(property="message", type="string", example="Service not found", description="Error message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error", description="Status of the operation"),
     *             @OA\Property(property="message", type="string", example="Internal Server Error", description="Error message")
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
     */
    public function getServiceDetailsByUsername($username)
    {
        try {
            // Retrieve the service based on the username
            $service = Service::where("username", $username)->first();

            if (!$service) {
                return response()->json(
                    [
                        "status" => "error",
                        "message" => "Service not found",
                    ],
                    404
                );
            }

            // Prepare the response data
            $responseData = [
                "id" => $service->id,
                "user_id" => $service->user_id,
                "package_id" => $service->package_id,
                "nas_id" => $service->nas_id,
                "price" => $service->price,
                "username" => $service->username,
                "password" => $service->cleartextpassword,
                "ip_address" => $service->ipaddress,
                "status" => $service->is_active ? "active" : "inactive",
                "renewal" => $service->renewal,
                "expiry" => $service->expiry,
                "description" => $service->description,
                "grace_expiry" => $service->grace_expiry,
                "mac_address" => $service->mac_address,
                "type" => $service->type,
                "info" => $service->info,
                "deleted_at" => $service->deleted_at,
                "created_at" => $service->created_at,
                "updated_at" => $service->updated_at,
            ];

            return response()->json([
                "status" => "success",
                "service" => $responseData,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => $e->getMessage(),
                ],
                500
            );
        }
    }


    /**
     * Delete a service .
     *
     * @OA\Delete(
     *     path="/api/services/{username}/delete-service",
     *     operationId="deleteService",
     *     tags={"Services"},
     *     summary="Delete a service ",
     *     description="This DELETE endpoint serves to delete a specific `service` associated with a given `username`. A valid API key (`x-api-key`) must be included in the request `header` for authentication. Once authenticated, the service identified by the provided username is deleted from the system. In cases where the requested service cannot be found, a `404` response is returned along with a descriptive error message indicating the absence of the service. Moreover, if the service to be deleted is currently `active`, the endpoint prevents deletion and responds with a `400` status code, accompanied by an explanatory message. In the event of an error, such as a model not found exception or an unexpected server error, the endpoint responds with a JSON object containing the relevant error status code and a detailed error message.",
     *     operationId="deleteService",
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
     *         description="Service username",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Service deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Service not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Internal Server Error")
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
     */
    public function delete_service(Request $request, $username)
    {
        try {
            // Find the service instance using ID
            $service = Service::where('username', $username)->first();
            if (!$service) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Service not found'
                ], 404);
            }

            // Check if service is active
            if ($service->is_active) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Failed. You can't delete an active service."
                ], 400);
            }

            // Get the necessary information for the NAS
            $nas = $service->nas;
            $nasip = $nas->nasname;
            $nasusername = $nas->nasprofile->username;
            $naspassword = $nas->nasprofile->password;

            // Dispatch the job before deleting the service
            UnblockUserJob::dispatch($service->ipaddress, $nasip, $nasusername, $naspassword);

            // Remove the user from the radcheck and radreply tables
            DB::table("radcheck")->where("username", "=", $service->username)->delete();
            DB::table("radreply")->where("username", "=", $service->username)->delete();

            // Permanently delete the service
            $service->forceDelete();

            // Log activity
            activity()
                ->performedOn($service)
                ->withProperties(['action' => 'deleted'])
                ->log('deleted service'.' '.$service->username);

            return response()->json([
                'status' => 'success',
                'message' => 'Client service deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Service not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
