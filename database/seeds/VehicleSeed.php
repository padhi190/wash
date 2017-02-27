<?php

use Illuminate\Database\Seeder;

class VehicleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'license_plate' => 'D 259 KKG', 'customer_id' => 2, 'type' => 'mobil', 'brand' => 'Suzuki', 'model' => 'Ertiga', 'color' => 'Hitam', 'size' => 'small', 'note' => null,],
            ['id' => 2, 'license_plate' => 'D 213 AZ', 'customer_id' => 1, 'type' => 'mobil', 'brand' => 'Toyota', 'model' => 'Kijang', 'color' => 'Abu-abu', 'size' => 'medium', 'note' => null,],
            ['id' => 3, 'license_plate' => 'D 977', 'customer_id' => 1, 'type' => 'mobil', 'brand' => 'Toyota', 'model' => 'Altis', 'color' => 'Hitam', 'size' => 'small', 'note' => null,],
            ['id' => 5, 'license_plate' => 'V 1 KY', 'customer_id' => 5, 'type' => 'mobil', 'brand' => 'Porsche', 'model' => 'Boxster', 'color' => 'Merah', 'size' => 'small', 'note' => null,],
            ['id' => 6, 'license_plate' => 'D 493 R', 'customer_id' => 3, 'type' => 'mobil', 'brand' => 'Toyota', 'model' => 'Innova', 'color' => 'Putih', 'size' => 'medium', 'note' => null,],
            ['id' => 7, 'license_plate' => 'R 47 IV', 'customer_id' => 3, 'type' => 'mobil', 'brand' => 'Lamborghini', 'model' => 'Aventador', 'color' => 'Orange', 'size' => 'medium', 'note' => null,],

        ];

        foreach ($items as $item) {
            \App\Vehicle::create($item);
        }
    }
}
