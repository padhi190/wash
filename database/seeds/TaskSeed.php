<?php

use Illuminate\Database\Seeder;

class TaskSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'branch_id' => 1, 'kendaraan_id' => 2, 'description' => null, 'status_id' => 2, 'due_date' => '23-02-2017', 'approval_date' => '',],

        ];

        // foreach ($items as $item) {
        //     \App\Task::create($item);
        // }

        // factory(App\Task::class, 50)->create();
    }
}
