<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 创建 100 个商品
        $products = factory(\App\Models\Product::class, 100)->create();
        foreach ($products as $product) {
            // 每个 product 创建 3 个 SKU，且每个 SKU 的 'product_id' 字段都设为当前商品 id
            $skus = factory(\App\Models\ProductSku::class, 3)->create(['product_id' => $product->id]);
            // 找出价格最低的 SKU 价格，并把商品价格设为此最低价
            $product->update(['price' => $skus->min('price')]);
        }
    }
}
