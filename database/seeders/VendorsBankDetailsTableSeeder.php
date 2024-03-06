<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetails;

class VendorsBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            ['id'=>1,'vendor_id'=>1,'account_holder_name'=>'john Mayambala','bank_name'=>'Centenary','account_number'=>'30001000101','bank_ifsc_code'=>'1244493939'],
        ];
        VendorsBankDetails::insert($vendorRecords);
    }
}
