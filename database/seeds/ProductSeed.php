<?php

use Illuminate\Database\Seeder;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'Frestea', 'description' => null, 'price' => '4000.00', 'photo1' => null, 'photo2' => null, 'photo3' => null,],
            ['id' => 2, 'name' => 'Ades', 'description' => null, 'price' => '2000.00', 'photo1' => null, 'photo2' => null, 'photo3' => null,],
            ['id' => 3, 'name' => 'Coca Cola', 'description' => null, 'price' => '4000.00', 'photo1' => null, 'photo2' => null, 'photo3' => null,],

        ];

        // foreach ($items as $item) {
        //     \App\Product::create($item);
        // }
    }
}
