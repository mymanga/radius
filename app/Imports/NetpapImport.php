<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NetpapImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            // Check if email already exists in the clients table
            $email = $row['email'];
            if ($email) {
                $emailExists = User::where('email', $email)->exists();
                if ($emailExists) {
                    Log::debug("Skipping row due to duplicate email: " . print_r($row, true));
                    return null; // Skip this record
                }
            }

            $username = $row['login'];
            if ($username) {
                $usernameExists = User::where('username', $username)->exists();
                if ($usernameExists) {
                    Log::debug("Skipping row due to duplicate username: " . print_r($row, true));
                    return null; // Skip this record
                }
            }

            // Generate a random password with 10 characters
            $randomPassword = Str::random(10);

            // Handle different name formats
            // Split the combined name into first and last names
            $names = explode(' ', $row['name'], 2);
            $firstName = $names[0] ?? '';
            $lastName = $names[1] ?? '';

            // Handle different GPS formats
            // Split the combined GPS field into latitude and longitude
            $gps = explode(',', $row['gps']);
            $latitude = $gps[0] ?? null;
            $longitude = $gps[1] ?? null;

            // Check the billingType field
            $billingType = $row['billing_type'] ?? 'monthly'; // Provide a default value if the key is not present

            if ($billingType === 'prepaid_monthly') {
                $billingType = 'monthly';
            }

            // Check the category field
            $category = $row['category'] ?? '';

            if (strtolower($category) === 'person') {
                $category = 'individual';
            } else {
                $category = 'business';
            }

            // Begin a transaction
            DB::beginTransaction();

            $client = new Client([
                'firstname' => $firstName,
                'lastname' => $lastName,
                'username' => $row['login'],
                'email' => $row['email'] ?? null,
                'location' => $row['city'] ?? null,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'phone' => $row['phone'] ?? null,
                'category' => $category,
                'billingType' => $billingType,
                'birthday' => $row['birthday'] ?? null,
                'identification' => $row['passport'] ?? null,
                'text_pass' => $row['password'] ?? $randomPassword,
                'email_verified_at' => now()->format('Y-m-d H:i:s'),
                'password' => $row['password'] ?? $randomPassword,
            ]);

            $client->save();

            // Commit the transaction
            DB::commit();

            return $client;

        } catch (\Exception $e) {
            // Rollback the transaction and log the error
            DB::rollBack();
            Log::error("Error importing row: " . print_r($row, true) . "\nException: " . $e->getMessage());
            return null;
        }
    }
}
        

