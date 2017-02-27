<?php

use Illuminate\Database\Seeder;

class TransferSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'branch_id' => 1, 'tanggal' => '23-02-2017 09:15:20', 'dari_id' => 1, 'ke_id' => 2, 'jumlah' => '2000000.00', 'note' => null,],

        ];

        foreach ($items as $item) {
            \App\Transfer::create($item);
        }
    }
}
