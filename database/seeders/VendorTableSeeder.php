<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\vendor;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            ['id'=>1,'name'=>'John','address'=>'CP-112','city'=>'kireka','state'=>'kampala','country'=>'Uganda','pincode'=>'110001','mobile'=>'0761488516','email'=>'edsonkusemererwa2000@gmail.com','status'=>0,],
        ];
        vendor::insert($vendorRecords);
    }
}
