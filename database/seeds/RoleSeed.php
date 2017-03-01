<?php

use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'title' => 'Administrator (dapat membuat pengguna lainnya)',],
            ['id' => 2, 'title' => 'User',],
            ['id' => 3, 'title' => 'Investor',],

        ];

        foreach ($items as $item) {
            \App\Role::create($item);
        }
    }
}