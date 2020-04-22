<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
    private $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }
    
    public function index()
    {
        $products = $this->product->orderBy('id', 'desc')->paginate(6);
        $stores = \App\Store::limit(3)->orderBy('id', 'desc')->get();

        return view('welcome', compact('products', 'stores'));
    }

    public function single($slug) {
        $product = $this->product->whereSlug($slug)->first();

        return view('single', compact('product'));
    }
}
