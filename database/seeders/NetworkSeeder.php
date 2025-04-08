<?php

namespace Database\Seeders;

use App\Models\Network;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class NetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Network::create([
            'id' => 1,
            'user_id' => 2,
            'qty' => 0,
        ]);
    }
}
