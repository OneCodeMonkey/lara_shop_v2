@extends('layouts.app')

@section('title', $product->title)

@section('content')
<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="card">
            <div class="card-body product-info">
                <div class="row">
                    <div class="col-5">
                        <img class="cover" src="{{ $product->image_url }}" alt="" />
                    </div>
                    <div class="col-7">
                        <div class="title">{{ $product->long_title ?: $product->title }}</div>
                        <!-- 众筹商品模块开始 -->
                        @if($product->type === \App\Models\Product::TYPE_CROWDFUNDING)
                        <div class="crowdfunding-info">
                            <div class="have-text">已筹到</div>
                            <div class="total-amount">
                                <span class="symbol">
                                    ￥
                                </span>
                                {{ $product->crowdfunding->total_amount }}
                            </div>

                            <!-- 这里使用 bootstrap 的进度条组件 -->
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="{{ $product->crowdfunding->percent }}" aria-valuemin="0" aria-valuemax="100" style="min-width: 1em;width: {{ min($product->crowdfunding->percent, 100) }}%;">
                                </div>
                            </div>

                            <div class="progress-info">
                                <span class="current-progress">
                                    当前进度：{{ $product->crowdfunding->percent }} %
                                </span>
                                <span class="float-right user-count">
                                    {{ $product->crowdfunding->user_count }}名支持者
                                </span>
                            </div>

                            <!-- 如果众筹状态是【众筹中】，则输出提示语 -->
                            @if($product->crowdfunding->status === \App\Models\CrowdfundingProduct::STATUS_FUNDING)
                            <div>
                                此项目必须在
                                <span class="text-red">
                                    {{ $product->crowdfunding->end_at->format('Y-m-d H:i:s') }}前得到
                                </span>
                                <span class="text-red">
                                    ￥{{ $product->crowdfunding->target_amount }}
                                </span>
                                的支持才可成功，
                                <!-- Carbon 对象的diffForHumans() 计算出人性化的提示语句 -->
                                筹款将于
                                <span class="text-red">
                                    {{ $product->crowdfunding->end_at->diffForHumans(now()) }}
                                </span>
                                结束！
                            </div>
                            @endif
                        </div>
                        @else
                        <!-- 原普通商品模块开始 -->
                        <div class="price">
                            <label>价格</label>
                            <em>￥</em>
                            <span>
                                {{ $product->price }}
                            </span>
                        </div>
                        <div class="sales_and_reviews">
                            <div class="sold_count">
                                累计销量
                                <span class="count">
                                    {{ $product->sold_count }}
                                </span>
                            </div>
                            <div class="review_count">
                                累计评价
                                <span class="count">
                                    {{ $product->review_count }}
                                </span>
                            </div>
                            <div class="rating" title="评分{{ $product->rating }}">
                                评分
                                <span class="count">
                                    {{ str_repeat('★', floor($product->rating)) }} {{ str_repeat('☆', 5 - floor($product->rating)) }}
                                </span>
                            </div>
                        </div>
                        <!-- 普通商品模块结束 -->
                        @endif
                        <!-- 众筹商品模块结束 -->
                        <div class="skus">
                            <label>选择</label>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                @foreach($product->skus as $sku)
                                <label class="btn-sku-btn" data-price="{{ $sku->price }}" data-stock="{{ $sku->stock }}" data-toggle="tooltip" title="{{ $sku->description }}" data-placement="bottom">
                                    <input type="radio" name="skus" autocomplete="off" value="{{ $sku->id }}" />
                                    {{ $sku->title }}
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="cart_amount">
                            <label>数量</label>
                            <input type="text" class="form-control form-control-sm" value="1" />
                            <span>件</span>
                            <span class="stock"></span>
                        </div>

                        <div class="buttons">
                            @if($favored)
                            <button class="btn btn-danger btn-disfavor">取消收藏</button>
                            @else
                            <button class="btn btn-success btn-favor">❤收藏</button>
                            @endif

                            <!-- 众筹商品下单按钮开始 -->
                            @if($product->type === \App\Models\Product::TYPE_CROWDFUNDING)
                                @if(Auth::check())
                                    @if($product->crowdfunding->status === \App\Models\CrowdfundingProduct::STATUS_FUNDING)
                                    <button class="btn btn-primary btn-crowdfunding">参与众筹</button>
                                    @else
                                    <button class="btn btn-primary disabled">
                                        {{ \App\Models\CrowdfundingProduct::$statusMap[$product->crowdfunding->status] }}
                                    </button>
                                    @endif
                                @else
                                <a class="btn btn-primary" href="{{ route('login') }}">请先登录</a>
                                @endif
                            <!-- 秒杀商品下单按钮开始 -->
                            @elseif($product->type === \App\Models\Product::TYPE_SECKILL)
                                @if(Auth::check())
                                    @if($product->seckill->is_before_start)
                                    <button class="btn btn-primary btn-seckill disabled countdown">抢购倒计时</button>
                                    @elseif($product->seckill->is_after_end)
                                    <button class="btn btn-primary btn-seckill disabled">抢购已结束</button>
                                    @else
                                    <button class="btn btn-primary btn-seckill">立即抢购</button>
                                    @endif
                                @else
                                <a class="btn btn-primary" href="{{ route('login') }}">请先登录</a>
                                @endif
                            <!-- 秒杀商品下单按钮结束 -->
                            @else
                            <button class="btn btn-primary btn-add-to-cart">加入购物车</button>
                            @endif
                            <!-- 众筹商品下单按钮结束 -->
                        </div>
                    </div>
                </div>

                <div class="product-detail">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@endsection
