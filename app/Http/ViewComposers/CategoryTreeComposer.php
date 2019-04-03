<?php

namespace App\Http\ViewComposers;

use App\Services\CategoryService;
use Illuminate\View\View;

class CategoryTreeComposer
{
    protected $categoryService;

    // 用依赖注入的用法
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    // 当渲染指定的模板时，Laravel自动调用compose()
    public function compose(View $view)
    {
        // 使用 with 方法注入变量
        $view->with('categoryTree', $this->categoryService->getCategoryTree());
    }
}
