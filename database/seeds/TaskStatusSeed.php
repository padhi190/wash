<?php

use Illuminate\Database\Seeder;

class TaskStatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'Open',],
            ['id' => 2, 'name' => 'Dalam Pengerjaan',],
            ['id' => 3, 'name' => 'Selesai',],
            ['id' => 4, 'name' => 'Sudah Diambil',],
            ['id' => 5, 'name' => 'Batal',],

        ];

        foreach ($items as $item) {
            \App\TaskStatus::create($item);
        }
    }
}
