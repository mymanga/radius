<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Network;

class NetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Network::create([
            'title'=> 'main',
            'comment' => 'Initial default network',
            'network' => '192.168.0.1',
            'subnet' => 24,
        ]);
    }
}
