<?php

use Illuminate\Database\Seeder;

class AccountSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'Cash', 'account_no' => null, 'holder_name' => null, 'branch' => null,],
            ['id' => 2, 'name' => 'BCA', 'account_no' => null, 'holder_name' => 'Vicky Kanaya', 'branch' => 'Asia Afrika',],
            ['id' => 3, 'name' => 'BRI', 'account_no' => null, 'holder_name' => null, 'branch' => null,],
            ['id' => 4, 'name' => 'BNI', 'account_no' => null, 'holder_name' => 'Vicky Kanaya', 'branch' => null,],

        ];

        foreach ($items as $item) {
            \App\Account::create($item);
        }
    }
}
