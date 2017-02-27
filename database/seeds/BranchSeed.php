<?php

use Illuminate\Database\Seeder;

class BranchSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'branch_name' => 'Kopo', 'address' => 'Kopo 168', 'city' => 'Bandung', 'phone' => null,],
            ['id' => 2, 'branch_name' => 'Buah Batu', 'address' => null, 'city' => 'Bandung', 'phone' => null,],

        ];

        foreach ($items as $item) {
            \App\Branch::create($item);
        }
    }
}
