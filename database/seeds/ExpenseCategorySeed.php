<?php

use Illuminate\Database\Seeder;

class ExpenseCategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'Kasbon',],
            ['id' => 2, 'name' => 'Marketing Fee',],
            ['id' => 3, 'name' => 'Bonus Pegawai',],
            ['id' => 4, 'name' => 'Gaji Salon',],
            ['id' => 5, 'name' => 'Bayar wax',],
            ['id' => 6, 'name' => 'Gaji Pegawai',],
            ['id' => 7, 'name' => 'Operasional',],
            ['id' => 8, 'name' => 'Lain-lain',],

        ];

        foreach ($items as $item) {
            \App\ExpenseCategory::create($item);
        }
    }
}
