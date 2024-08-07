<?php

// app/Gateways/UserDefined/YourGatewaySmsGateway.php
namespace App\Gateways\UserDefined;

/**
 * Naming Convention Guidelines:
 *
 * 1. File Naming:
 *    - The filename should be named with only one name of the gateway followed by 'SmsGateway'.
 *    - Example: If the gateway name is 'SimpleISP', the filename should be 'SimpleISPSmsGateway.php'.
 *
 * 2. Class Naming:
 *    - The class name within the file should follow the format 'GatewayNameSmsGateway'.
 *    - Example: If the gateway name is 'SimpleISP', the class name should be 'SimpleISPSmsGateway'.
 *
 * 3. Gateway Name:
 *    - The gateway name used in the filename and class name should be in CamelCase.
 *    - Example: If the gateway name is 'simpleisp', it should be transformed to 'SimpleISP'.
 *
 * Example Usage:
 * Assuming the gateway name is 'SimpleISP':
 *
 * 1. Filename: SimpleISPSmsGateway.php
 * 2. Class Name: SimpleISPSmsGateway
 * 3. Gateway Name: SimpleISP
 *
 * Following these conventions ensures consistency and clarity across different SMS gateways.
 * Developers should adhere to these guidelines when creating new SMS gateway implementations.
 */

class AdvantaSmsGateway
{
    /**
     * Get information about the Your Gateway SMS gateway.
     * This method provides essential information about the SMS gateway, helping users understand its purpose and origin.
     * The returned array contains the following key-value pairs:
     *   - 'name': The name or title of the SMS gateway. This should be a descriptive and unique identifier for the gateway.
     *   - 'description': A brief description of the SMS gateway, outlining its functionality and purpose.
     *   - 'author': The name of the individual or organization responsible for developing the SMS gateway.
     *   - 'website': The URL of the official website or documentation related to the SMS gateway.
     *
     * Example Usage:
     * ```
     * 'name' => 'Your Gateway name',
     * 'description' => 'A gateway for sending SMS via Your Gateway API.',
     * 'author' => 'Your Name',
     * 'website' => 'https://your-website.com',
     * ```
     *
     * This method is crucial for providing users, developers, and administrators with clear and concise information 
     * about the SMS gateway. The details supplied here help users identify, evaluate, and use the gateway effectively.
     *
     * Note: Ensure that the 'name' provided is unique and representative of the gateway. The 'website' URL should lead to
     * relevant documentation or the official source for additional information.
     *
     * @return array An associative array containing information about the Your Gateway SMS gateway.
     */
    public static function getGatewayInfo()
    {
        return [
            'name' => 'Advanta Sms Gateway',
            'description' => 'A gateway for sending SMS via Your Advanta API.',
            'author' => 'SimpleISP',
            'website' => 'https://simplux.africa',
        ];
    }


    /**
     * Get configuration parameters for the SimpleISP SMS gateway.
     * These parameters define the settings required for the functionality of the SimpleISP SMS gateway. 
     * Each parameter corresponds to an input field in the configuration form and is used to customize 
     * the behavior of the gateway. Developers should ensure that the keys in the returned array 
     * match the expected configuration parameters for their gateway.
     *
     * Each configuration parameter is represented as an associative array with the following properties:
     *   - 'label': The label or title for the configuration field displayed in the form.
     *   - 'type': The HTML input type for the field (e.g., 'text', 'hidden', 'select').
     *   - 'name': The unique name or identifier for the configuration parameter. This name will be used 
     *            as the key when saving and retrieving the parameter value.
     *   - 'value': The default or current value of the configuration parameter retrieved from the application's settings.
     *              It's important to note that the value inside 'setting()' should strictly correspond to the 'name' 
     *              given above. For consistency, always use 'setting()' to retrieve values, ensuring they match the
     *              parameter names provided here.
     * 
     * Example Usage:
     * ```
     * 'api_key' => [
     *     'label' => 'API Key',
     *     'type' => 'text',
     *     'name' => 'simpleisp_api_key', // Replace with your gateway API key name
     *     'value' => setting('simpleisp_api_key'),
     * ],
     * ```
     *
     * This method is used to generate the form fields dynamically based on the configuration parameters 
     * and is crucial for providing a seamless user interface for updating gateway settings.
     *
     * Note: Whatever is placed inside 'setting()' should strictly correspond to the 'name' given above, ensuring
     * consistency and proper retrieval of configuration values.
     *
     * @return array An associative array of configuration parameters for the SimpleISP SMS gateway.
     */
    public static function getConfigParameters()
    {
        return [
            'gateway' => [
                'label' => 'Gateway',
                'type' => 'hidden',
                'name' => 'advanta_gateway', // Replace with your gateway name
                'value' => setting("advanta_gateway"),
            ],
            // Add additional configuration parameters for your gateway here
            'apiKey' => [
                'label' => 'API Key',
                'type' => 'text',
                'name' => 'advanta_api_key',
                'value' => setting("advanta_api_key"),
            ],
            'partner_id' => [
                'label' => 'Partner ID',
                'type' => 'text',
                'name' => 'advanta_partner_id', // Added name attribute
                'value' => setting('advanta_partner_id'),
            ],
            'senderId' => [
                'label' => 'Sender ID',
                'type' => 'text',
                'name' => 'advanta_sender_id',
                'value' => setting("advanta_sender_id"),
            ],
        ];
    }


    /**
     * Send SMS using the Your Gateway API.
     *
     * @param string $phone
     * @param string $message
     * @return array An array containing the parameters to send SMS.
     */
    public function sendSms($phone, $message)
    {
        $endpoint = "https://quicksms.advantasms.com/api/services/sendsms/";

        $apiKey = setting("advanta_api_key");
        $partnerID = setting('advanta_partner_id');
        $shortcode = setting("advanta_sender_id");

        $postData = array(
            "apikey" => $apiKey,
            "partnerID" => $partnerID,
            "message" => $message,
            "shortcode" => $shortcode,
            "mobile" => $phone
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return ['status' => 'error', 'message' => 'cURL Error: ' . curl_error($ch)];
        }

        curl_close($ch);

        $responseArray = json_decode($response, true);

        if (isset($responseArray['responses'][0]['response-code']) && $responseArray['responses'][0]['response-code'] == 200) {
            // Message sent successfully
            $messageId = $responseArray['responses'][0]['messageid'];
            return ['status' => 'success', 'message' => 'Message sent successfully! Message ID: ' . $messageId];
        } else {
            // Handle the error
            return ['status' => 'error', 'message' => 'Failed to send message. ' . json_encode($responseArray)];
        }
    }


    /**
     * Fetches account balance using the Your Gateway API.
     *
     * @return array An array containing the balance information.
     * The expected output should be in the format:
     * [
     *    "units" => 'units',  // Replace 'units' with the actual units used by your gateway (optional)
     *    "value" => $value, // Replace $value with the actual SMS balance value
     * ]
     */
    public function advantaSmsBalance()
    {
        // Get the API key and partner ID from the settings
        $apiKey = setting("advanta_api_key");
        $partnerID = setting('advanta_partner_id');

        // Set the endpoint URL
        $endpoint = 'https://quicksms.advantasms.com/api/services/getbalance/';

        // Prepare the request body
        $postData = [
            'apikey' => $apiKey,
            'partnerID' => $partnerID
        ];

        // Initialize cURL
        $curl = curl_init();

        // Set the cURL options for the GET request
        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ]);

        // Execute the cURL request and store the response
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            curl_close($curl);
            return null;
        }

        // Close the cURL session
        curl_close($curl);

        // Convert the JSON response to an associative array
        $balanceData = json_decode($response, true);

        // Check if the response code is 200 and 'credit' is present
        if (isset($balanceData['response-code']) && $balanceData['response-code'] == 200 && isset($balanceData['credit'])) {
            // Extract the credit value from the response
            $value = floatval($balanceData['credit']);

            // You can set the currency as needed by your API
            $units = "units"; // Adjust this based on the actual response

            return ['value' => $value, 'units' => $units];
        } else {
            return null;
        }
    }

}
