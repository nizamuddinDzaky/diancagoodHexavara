<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Customer::truncate();
        
        User::create([
            'name' => 'admin1',
            'email' => 'admin1@dianca.id',
            'password' => Hash::make('asdasdasd')
        ]);

        $customers = [
            [
                'name' => 'cust verif',
                'email' => 'butsherlock@gmail.com',
                'password' => Hash::make('asdasdasd'),
                'phone_number' => '123123123',
                'address' => 'Jalan Mulyosari 37',
                'district_id' => 6145
            ],
            [
                'name' => 'Rizal Adam',
                'email' => 'rizaladam@gmail.com',
                'password' => Hash::make('asdasdasd'),
                'phone_number' => '123123123',
                'address' => 'Jalan Mulyosari 37',
                'district_id' => 6145
            ],
        ];

        Customer::insert($customers);
    }
}
