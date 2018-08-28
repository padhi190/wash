<?php

use Illuminate\Database\Seeder;

class CustomerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'branch_id' => 1, 'name' => 'Pitra', 'sex' => 'Laki-laki', 'phone' => '081322999456', 'join_date' => '23-02-2017', 'note' => null,],
            ['id' => 2, 'branch_id' => 1, 'name' => 'Andhan', 'sex' => 'Perempuan', 'phone' => '08122118611', 'join_date' => '23-02-2017', 'note' => null,],
            ['id' => 3, 'branch_id' => 1, 'name' => 'Rajiv', 'sex' => 'Laki-laki', 'phone' => '08122363622', 'join_date' => '21-02-2017', 'note' => null,],
            ['id' => 5, 'branch_id' => 2, 'name' => 'Vicky', 'sex' => 'Laki-laki', 'phone' => null, 'join_date' => '07-02-2017', 'note' => null,],

        ];

        foreach ($items as $item) {
            \App\Customer::create($item);
        }

        factory(App\Customer::class, 5000)->create();
    }
}
