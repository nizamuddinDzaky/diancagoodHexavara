<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use App\Models\Address;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderDetail;
use App\Models\Bank;
use Carbon\Carbon;

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
        Order::truncate();
        OrderDetail::truncate();
        
        User::create([
            'name' => 'admin1',
            'email' => 'admin1@dianca.id',
            'password' => 'asdasdasd'
        ]);

        $customers = [
            [
                'name' => 'cust verif',
                'email' => 'butsherlock@gmail.com',
                'password' => Hash::make('asdasdasd'),
                'phone_number' => '123123123',
                'address' => 1,
                'district_id' => 6145
            ],
            [
                'name' => 'Rizal Adam',
                'email' => 'rizaladam@gmail.com',
                'password' => Hash::make('asdasdasd'),
                'phone_number' => '123123123',
                'address' => 0,
                'district_id' => 6145
            ],
            [
                'name' => 'Afia Hana',
                'email' => 'afia@gmail.com',
                'password' => Hash::make('asdasdasd'),
                'phone_number' => '123123123',
                'address' => 0,
                'district_id' => 6145
            ],
            [
                'name' => 'Reva',
                'email' => 'reva@gmail.com',
                'password' => Hash::make('asdasdasd'),
                'phone_number' => '123123123',
                'address' => 0,
                'district_id' => 6145
            ],
        ];

        Address::create([
            'customer_id' => 1,
            'address_type' => "Rumah",
            'receiver_name' => "Rosa",
            'receiver_phone' => '0812128127',
            'district_id' => 6145,
            'postal_code' => "60112",
            'address' => 'Jalan Mulyosari Tengah VII/37',
            'is_main' => true
        ]);

        Order::create([
            'invoice' => 'DG001228122020AV',
            'customer_id' => 1,
            'customer_name' => 'cust verif',
            'customer_email' => 'butsherlock@gmail.com',
            'customer_phone' => '123123123',
            'address_id' => 1,
            'subtotal' => 400000,
            'shipping_cost' => 25000,
            'total_cost' => 425000,
            'shipping' => 'JNE',
            'status' => 0,
            'unique' => rand(1, 99),
            'tracking_number' => 'JJA000021928',
            'invalid_at' => Carbon::now()->addMinutes(30),
            'created_at' => '2021-03-16 20:24:49'
        ]);

        Order::create([
            'invoice' => 'HN001228122020RT',
            'customer_id' => 1,
            'customer_name' => 'cust verif',
            'customer_email' => 'butsherlock@gmail.com',
            'customer_phone' => '123123123',
            'address_id' => 1,
            'subtotal' => 500000,
            'shipping_cost' => 15000,
            'total_cost' => 515000,
            'shipping' => 'JNE',
            'status' => 3,
            'unique' => rand(1, 99),
            'tracking_number' => 'KKA000021901',
            'invalid_at' => Carbon::now()->addMinutes(30),
            'created_at' => '2021-03-16 21:24:49'
        ]);

        Order::create([
            'invoice' => 'ZP001328122084KT',
            'customer_id' => 1,
            'customer_name' => 'cust verif',
            'customer_email' => 'butsherlock@gmail.com',
            'customer_phone' => '123123123',
            'address_id' => 1,
            'subtotal' => 150000,
            'shipping_cost' => 25000,
            'total_cost' => 175000,
            'shipping' => 'JNE',
            'status' => 0,
            'unique' => rand(1, 99),
            'tracking_number' => 'MHA000021541',
            'invalid_at' => Carbon::now()->addMinutes(30),
            'created_at' => '2021-02-16 20:24:49'
        ]);

        Payment::create([
            'order_id' => 1,
            'transfer_to' => 'BNI',
            'method' => 'Transfer',
            'amount' => 425000,
            'created_at' => '2021-03-16 21:24:49'
        ]);

        Payment::create([
            'order_id' => 2,
            'transfer_to' => 'BNI',
            'method' => 'Transfer',
            'amount' => 515000,
            'created_at' => '2021-03-16 21:24:49'
        ]);

        Payment::create([
            'order_id' => 3,
            'transfer_to' => 'BRI',
            'method' => 'Transfer',
            'amount' => 175000,
            'created_at' => '2021-02-16 21:24:49'
        ]);

        $order_details = [
            [
                'order_id' => 1,
                'product_variant_id' => 1,
                'price' => 400000,
                'qty' => 2,
                'weight' => 60,
                'created_at' => '2021-03-16 20:24:49'
            ],
            [
                'order_id' => 2,
                'product_variant_id' => 1,
                'price' => 200000,
                'qty' => 1,
                'weight' => 60,
                'created_at' => '2021-03-16 21:24:49'
            ],
            [
                'order_id' => 2,
                'product_variant_id' => 3,
                'price' => 300000,
                'qty' => 2,
                'weight' => 200,
                'created_at' => '2021-03-16 21:24:49'
            ],
            [
                'order_id' => 3,
                'product_variant_id' => 3,
                'price' => 150000,
                'qty' => 1,
                'weight' => 200,
                'created_at' => '2021-02-16 21:24:49'
            ],
        ];

        $banks = [
            [
                'name' => 'PT. BANK NEGARA INDONESIA (BNI)',
                'image' => 'BNI.png'
            ]
        ];

        Customer::insert($customers);
        OrderDetail::insert($order_details);
        Bank::insert($banks);
    }
}
