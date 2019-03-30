<?php

namespace App\Console\Commands\Cron;

use App\Jobs\RefundCrowdfundingOrders;
use App\Models\CrowdfundingProduct;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FinishCrowdfunding extends Command
{
    protected $signature = 'cron:finish-crowdfunding';

    protected $description = '结束众筹';

    public function handle()
    {
        CrowdfundingProduct::query()
            ->with(['product'])
            // 众筹结束时间早于当前时间
            ->where('end_at', '<=', Carbon::now())
            // 众筹状态为众筹中
            ->where('status', CrowdfundingProduct::STATUS_PENDING)
            ->get()
            ->each(function (CrowdfundingProduct $crowdfundingProduct) {
                // 如果众筹目标金额大于实际众筹金额
                if ($crowdfundingProduct->target_amount > $crowdfundingProduct->total_amount) {
                    // 调用众筹失败的逻辑
                    $this->crowdfundingFailed($crowdfundingProduct);
                } else {
                    // 实际金额已达到众筹金额
                    $this->crowdfundingSucceed($crowdfundingProduct);
                }
            });
    }
}
