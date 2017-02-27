<?php

use Illuminate\Database\Seeder;

class IncomeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'branch_id' => 1, 'vehicle_id' => 1, 'entry_date' => '22-02-2017 12:00:00', 'income_category_id' => 1, 'product_id' => null, 'qty' => 1, 'amount' => '40000', 'discount' => '10000.00', 'payment_type_id' => 1, 'note' => null,],
            ['id' => 2, 'branch_id' => 2, 'vehicle_id' => 1, 'entry_date' => '13-02-2017 12:00:00', 'income_category_id' => 3, 'product_id' => null, 'qty' => 1, 'amount' => '1000000', 'discount' => null, 'payment_type_id' => 2, 'note' => null,],
            ['id' => 3, 'branch_id' => 1, 'vehicle_id' => 2, 'entry_date' => '11-01-2017 12:00:00', 'income_category_id' => 1, 'product_id' => null, 'qty' => 1, 'amount' => '40000', 'discount' => null, 'payment_type_id' => 4, 'note' => null,],
            ['id' => 4, 'branch_id' => 1, 'vehicle_id' => 2, 'entry_date' => '25-02-2017 07:15:11', 'income_category_id' => 4, 'product_id' => 1, 'qty' => 1, 'amount' => '4000', 'discount' => null, 'payment_type_id' => 1, 'note' => null,],

        ];

        foreach ($items as $item) {
            \App\Income::create($item);
        }
    }
}
