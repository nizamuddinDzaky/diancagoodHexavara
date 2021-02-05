<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;

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

        Order::create([
            'invoice' => 'DG001228122020AV',
            'customer_id' => 1,
            'customer_name' => 'cust verif',
            'customer_email' => 'butsherlock@gmail.com',
            'customer_phone' => '123123123',
            'customer_address' => 'Jalan Mulyosari 37',
            'district_id' => 6145,
            'subtotal' => 858000,
            'shipping_cost' => 20000,
            'total_cost' => 878000,
            'shipping' => 'JNE',
            'status' => 0,
            'tracking_number' => 'JJA000021928'
        ]);

        $order_details = [
            [
                'order_id' => 1,
                'product_variant_id' => 1,
                'price' => 258000,
                'qty' => 1,
                'weight' => 60
            ],
            [
                'order_id' => 1,
                'product_variant_id' => 2,
                'price' => 300000,
                'qty' => 2,
                'weight' => 200
            ],
            [
                'order_id' => 2,
                'product_variant_id' => 1,
                'price' => 258000,
                'qty' => 1,
                'weight' => 60
            ],
            [
                'order_id' => 2,
                'product_variant_id' => 2,
                'price' => 300000,
                'qty' => 2,
                'weight' => 200
            ]
        ];

        Order::create([
            'invoice' => 'DG001228122020BW',
            'customer_id' => 1,
            'customer_name' => 'cust verif',
            'customer_email' => 'butsherlock@gmail.com',
            'customer_phone' => '123123123',
            'customer_address' => 'Jalan Mulyosari 37',
            'district_id' => 6145,
            'subtotal' => 858000,
            'shipping_cost' => 20000,
            'total_cost' => 878000,
            'shipping' => 'JNE',
            'status' => 1,
            'tracking_number' => 'JJA000021928'
        ]);

        Customer::insert($customers);
        OrderDetail::insert($order_details);
    }
}
