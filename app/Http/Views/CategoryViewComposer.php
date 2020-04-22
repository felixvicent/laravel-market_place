<?php

namespace App\Http\Views;

use App\Category;

class CategoryViewComposer{
    protected $category;

    public function __construct(Category $category){
        $this->category = $category;
    }

    public function compose($view){
        $categories = $this->category::all();

        return $view->with('categories', $categories);
    }
}