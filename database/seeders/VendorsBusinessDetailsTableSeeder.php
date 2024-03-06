<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetails;

class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            ['id'=>1,'vendor_id'=>1,'shop_name'=>'john_electronics_store','shop_address'=>'1234-SCF','shop_city'=>'kireka','shop_state'=>'kampala','shop_country'=>'Uganda','shop_pincode'=>'110001','shop_mobile'=>'0761488516','shop_website'=>'sitemakers.in','shop_email'=>'johnelec@gmail.com','address_proof'=>'national_id','address_proof_image'=>'test.jpg','business_license_number'=>'464567389','gst_number'=>'465789898','pan_number'=>'464567386',],
        ];
        VendorsBusinessDetails::insert($vendorRecords);
    }
}
