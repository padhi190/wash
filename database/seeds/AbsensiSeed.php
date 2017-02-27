<?php

use Illuminate\Database\Seeder;

class AbsensiSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'branch_id' => 2, 'tanggal' => '25-02-2017', 'karyawan_id' => 1, 'note' => null,],

        ];

        foreach ($items as $item) {
            \App\Absensi::create($item);
        }
    }
}
