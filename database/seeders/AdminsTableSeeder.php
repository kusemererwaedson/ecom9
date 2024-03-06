<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords = [
            ['id'=>2,'name'=>'Super Admin','type'=>'vendor','vendor_id'=>1,'mobile'=>'0761488516','email'=>'edsonkusemererwa@gmail.com','password'=>'$2a$12$i8ofk71N3SjoA7/9i5/aIOgQK1FJZ3ykFirkvi1z9kWuwMAYq4jhi','image'=>'','status'=>0],
        ];
        Admin::insert($adminRecords);
    }
}
