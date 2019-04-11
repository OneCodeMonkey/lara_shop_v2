@extends('layouts.app')

@section('title', '购物车')
@section('content')
<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="card">
            <div class="card-header">我的购物车</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>商品信息</th>
                        <th>单价</th>
                        <th>数量</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody class="product_list">
                    @foreach($cartItem as $item)
                        <tr data-id="{{ $item->productSku->id }}">
                            <td>
                                <input type="checkbox" name="select" value="{{ $item->productSku->id }}" {{ $item->productSku->product->on_sale ? 'checked' : 'disabled' }} />
                            </td>
                            <td class="product-info">
                                <div class="preview">
                                    <a target="_blank" href="{{ route('products.show', [$item->productSku->product_id]) }}">
                                        <img src="{{ $item->productSku->product->image_url }}"/>
                                    </a>
                                </div>

                                <div @if(!$item->productSku->product->on_sale) class="not_on_sale" @endif>
                                    <span class="product_title">
                                        <a target="_blank" href="{{ route('products.show', [$item->productSku->product_id]) }}">
                                            {{ $item->productSku->product->title }}
                                        </a>
                                    </span>
                                    <span class="sku_title">
                                        {{ $item->productSku->title }}
                                    </span>
                                    @if(!$item->productSku->product->on_sale)
                                        <span class="warning">该商品已下架</span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <span class="price">￥{{ $item->productSku->price }}</span>
                            </td>

                            <td>
                                <input type="text" class="form-control form-control-sm amount" @if(!$item->productSku->product->on_sale) disabled @endif name="amount" value="{{ $item->amount }}" />
                            </td>

                            <td>
                                <button class="btn btn-sm btn-danger btn-remove">移除</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- 开始 -->
                <div>
                    <form class="form-horizontal" role="form" id="order-form">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-3 text-md-right">选择收获地址</label>
                            <div class="col-sm-9 col-md-7">
                                <select class="form-control" name="address">
                                    @foreach($addresses as $address)
                                        <option value="{{ $address->id }}">
                                            {{ $address->full_address }} {{ $address->contact_name }} {{ $address->contact_phone }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-3 text-md-right">备注</label>
                            <div class="col-sm-9 col-md-7">
                                <textarea name="remark" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <!-- 优惠码开始 -->
                        <div class="form-group row">
                            <label class="col-form-label col-sm-3 text-md-right">优惠码</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="coupon_code" />
                                <span class="form-text text-muted" id="coupon_desc"></span>
                            </div>
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-success" id="btn-check-coupon">检查</button>
                                <button type="button" class="btn btn-danger" style="display: none;" id="btn-cancel-coupon">取消</button>
                            </div>
                        </div>
                        <!-- 优惠码结束 -->

                        <div class="form-group">
                            <div class="offset-sm-3 col-sm-3">
                                <button type="button" class="btn btn-primary btn-create-order">提交订单</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- 结束 -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptsAfterJs')
<script>
    $(document).ready(function () {
        // 监听【移除】按钮的点击事件
        $('.btn-remove').click(function () {
            // closest()可获取到匹配选择器的第一个祖先元素，在这里就是当前点击的【移除】按钮上的<tr>标签
            // data('id')可获取之前设置的 data-id 属性的值，也即对应的SKU id
            var id = $(this).closest('tr').data('id');
            swal({
                title: "确认要将该商品移除？",
                icon: "warning",
                buttons: ['取消', '确定'],
                dangerMode: true,
            })
                .then(function (willDelete) {
                    // 用户点击
                })
        })

        // 监听【全选/取消全选】单选框的变更事件

        // 监听【创建订单】按钮的点击事件

        // 【检查】按钮点击事件

        // 【隐藏】按钮点击事件
    })
</script>
@endsection
@endsection