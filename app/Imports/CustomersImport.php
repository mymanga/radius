<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use ZipArchive;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Check if email already exists in the clients table
        $email = $row['email'];
        if ($email) {
            $emailExists = User::where('email', $email)->exists();
            if ($emailExists) {
                Log::debug("Skipping row due to duplicate email: " . print_r($row, true));
                return null; // Skip this record
            }
        }

        $username = $row['username'];
        if ($username) {
            $usernameExists = User::where('username', $username)->exists();
            if ($usernameExists) {
                Log::debug("Skipping row due to duplicate username: " . print_r($row, true));
                return null; // Skip this record
            }
        }

        // Generate a random password with 10 characters
        $randomPassword = Str::random(10);

        // Bcrypt the current time
        $bcryptTime = bcrypt(time());

        return new Client([
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'username' => $row['username'],
            'email' => $row['email'],
            'location' => $row['location'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'phone' => $row['phone'],
            'category' => $row['category'],
            'billingType' => $row['billingType'] ?? null, // Provide a default value if the key is not present
            'birthday' => $row['birthday'],
            'identification' => $row['identification'],
            'text_pass' => $row['password'],
            'email_verified_at' => now()->format('Y-m-d H:i:s'),
            'password' => $row['password'],
        ]);
    }
}
