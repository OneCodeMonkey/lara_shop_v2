<?php

namespace App\Services;

use App\Models\Category;
use DemeterChain\C;

class CategoryService
{
    // 这是一个递归的方法，$parentId 表示要获取子类目的父类目 ID, null 代表获取所有根目录
    // $allCategories 参数代表数据库中所有的类目，如果是null，代表需要从数据库中查询
    public function getCategoryTree($parentId = null, $allCategories = null)
    {
        if (is_null($allCategories)) {
            // 从数据库中一次性取出所有类目
            $allCategories = Category::all();
        }

        return $allCategories
            ->where('parent_id', $parentId)
            ->map(function (Category $category) use ($allCategories) {
                $data = ['id' => $category->id, 'name' => $category->name];
                // 如果当前类目不是父类目，则直接返回
                if (!$category->is_directory) return $data;
                // 当前类目是父类目，则递归调用本方法，将返回值放入 children 字段
                $data['children'] = $this->getCategoryTree($category->id, $allCategories);

                return $data;
            });
    }
}
