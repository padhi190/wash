<?php

use Illuminate\Database\Seeder;

class ExpenseSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'branch_id' => 2, 'expense_category_id' => 1, 'employee_id' => 1, 'entry_date' => '24-02-2017', 'amount' => '50000', 'from_id' => 1, 'note' => null,],
            ['id' => 2, 'branch_id' => 1, 'expense_category_id' => 1, 'employee_id' => 2, 'entry_date' => '24-02-2017', 'amount' => '100000', 'from_id' => 1, 'note' => null,],
            ['id' => 3, 'branch_id' => 1, 'expense_category_id' => 7, 'employee_id' => null, 'entry_date' => '25-02-2017', 'amount' => '32000', 'from_id' => 1, 'note' => 'Galon',],

        ];

        // foreach ($items as $item) {
        //     \App\Expense::create($item);
        // }

        factory(App\Expense::class, 1000)->create();
    }
}
