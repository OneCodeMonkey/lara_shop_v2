<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\OrderItem;

// 此类实现 ShouldQueue 代表是一个异步监听器
class UpdateProductSoldCount implements ShouldQueue
{
    // Laravel 会默认执行 listener 的 handle 方法，触发的事件作为 handle() 的参数
    public function handle(OrderPaid $event)
    {
        // 从事件对象中取出对应的订单
        $order = $event->getOrder();
        // 预加载商品数据
        $order->load('items.product');
        // 循环遍历订单的商品
        foreach ($order->items as $item) {
            $product = $item->product;
            // 计算对应的商品的销量
            $soldCount = OrderItem::query()
                ->where('product_id', $product->id)
                ->whereHas('order', function ($query) {
                    $query->whereNotNull('paid_at'); // 关联的订单状态要是【已支付】
                })
                ->sum('amount');

            $product->update([
                'sold_count' => $soldCount,
            ]);
        }
    }
}
