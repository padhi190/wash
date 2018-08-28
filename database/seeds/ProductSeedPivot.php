<?php

use Illuminate\Database\Seeder;

class ProductSeedPivot extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            1 => [
                'category' => [1],
                'tag' => [],
            ],
            2 => [
                'category' => [1],
                'tag' => [],
            ],
            3 => [
                'category' => [1],
                'tag' => [],
            ],

        ];

        // foreach ($items as $id => $item) {
        //     $product = \App\Product::find($id);

        //     foreach ($item as $key => $ids) {
        //         $product->{$key}()->sync($ids);
        //     }
        // }
    }
}
