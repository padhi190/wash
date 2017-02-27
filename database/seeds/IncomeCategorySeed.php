<?php

use Illuminate\Database\Seeder;

class IncomeCategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'Carwash', 'price' => '40000.00',],
            ['id' => 2, 'name' => 'Wax', 'price' => '100000.00',],
            ['id' => 3, 'name' => 'Detailing', 'price' => '1000000.00',],
            ['id' => 4, 'name' => 'F&B', 'price' => null,],

        ];

        foreach ($items as $item) {
            \App\IncomeCategory::create($item);
        }
    }
}
