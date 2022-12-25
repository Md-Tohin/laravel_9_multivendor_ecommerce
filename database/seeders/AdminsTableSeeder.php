<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $adminRecords = [
            ['id'=>1, 'name'=>'Admin', 'type'=>'admin', 'vendor_id'=>0, 'mobile'=>'01854229083', 'email'=>'mdtohin8585@gmail.com', 'password'=>'$2y$10$kME7Gfvf.zdgy3vDIGYG7uJRue7zfJtLldn8Wk19knhrwkhhYoDja', 'image'=>'', 'status'=>1],
            ['id'=>2, 'name'=>'John', 'type'=>'vendor', 'vendor_id'=>1, 'mobile'=>'01742712993', 'email'=>'john@gmail.com', 'password'=>'$2y$10$kME7Gfvf.zdgy3vDIGYG7uJRue7zfJtLldn8Wk19knhrwkhhYoDja', 'image'=>'', 'status'=>1]
        ];
        Admin::insert($adminRecords);
    }
}
