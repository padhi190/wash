<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'Admin', 'email' => 'admin@admin.com', 'password' => '$2y$10$ua6M5ZhM09vnGrSwmATbpuDFJtHKnRuZJ3S23A/e4fPN/44OE7wTa', 'role_id' => 1, 'remember_token' => '', 'branch_id' => 1,],
            ['id' => 2, 'name' => 'User Kopo', 'email' => 'userkopo@user.com', 'password' => '$2y$10$jUY7Ppwn0BXma8nlMwtHI.3qr1/9hECkqbaqPD8Th1OdksnwsSIqW', 'role_id' => 2, 'remember_token' => null, 'branch_id' => 1,],
            ['id' => 3, 'name' => 'User Buah Batu', 'email' => 'userbubat@user.com', 'password' => '$2y$10$g2Fn7la49CffDmsYRCAzN.3gKiH4oBc.KzEoE9UBIyBGwxyEl3MkO', 'role_id' => 2, 'remember_token' => null, 'branch_id' => 2,],

        ];

        foreach ($items as $item) {
            \App\User::create($item);
        }
    }
}
