<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Notifications\OrderPaidNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

// 异步监听器
class SendOrderPaidMail implements ShouldQueue
{
    public function handle(OrderPaid $event)
    {
        // 从事件对象里取出对应的订单
        $order = $event->getOrder();
        // 调用 notify() 发送通知
        $order->user->notify(new OrderPaidNotification($order));
    }
}
