<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CMSUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $privileges = [
            "Super Administrator"
        ];
        foreach ($privileges as $rowP) {
            $objP = [
                "name" => $rowP,
                "created_at" => date('Y-m-d H:i:s'),
            ];
            if (Schema::hasTable('cms_privileges')) {
                DB::table('cms_privileges')->insertOrIgnore($objP);
            }
        }

        $this->command->info('cms_privileges is generated');


        $users = [
            0 => [
                "name" => "Admin Backend",
                "email" => "admin@backend.com",
                "password" => Hash::make('123456'),
                "cms_privileges_id" => "1",
            ],
        ];
        foreach ($users as $rowU) {
            $objU = $rowU + [
                "created_at" => date('Y-m-d H:i:s'),
            ];
            if (Schema::hasTable('cms_users')) {
                DB::table('cms_users')->insertOrIgnore($objU);
            }
        }

        $this->command->info('cms_users is generated');

        $this->command->info("You can login in backend with users: admin@backend.com, password: 123456");

    }
}
