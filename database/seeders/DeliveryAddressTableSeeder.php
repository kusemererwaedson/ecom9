<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryRecords = [
            ['id'=>1,'user_id'=>1,'name'=>'Edson Kusemererwa','address'=>'123-a','city'=>'Kampala','state'=>'Kireka','country'=>'Uganda','pincode'=>10001,'mobile'=>9800000000,'status'=>1],
            ['id'=>2,'user_id'=>1,'name'=>'Edson Kusemererwa','address'=>'12345-a','city'=>'Kampala','state'=>'Kireka','country'=>'Uganda','pincode'=>141001,'mobile'=>9700000000,'status'=>1]
        ];
        DeliveryAddress::insert($deliveryRecords);
    }
}
