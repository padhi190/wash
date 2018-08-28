<?php

use Illuminate\Database\Seeder;

class EmployeeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'Morin', 'gender' => 'Perempuan', 'join_date' => '05-08-2015', 'posisi' => null, 'status' => 1, 'branch_id' => 2,],
            ['id' => 2, 'name' => 'Dewi', 'gender' => 'Perempuan', 'join_date' => '01-02-2017', 'posisi' => null, 'status' => 1, 'branch_id' => 2,],

        ];

        // foreach ($items as $item) {
        //     \App\Employee::create($item);
        // }
    }
}
