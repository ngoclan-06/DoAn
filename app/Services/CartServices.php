<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\cart;
use App\Models\products;

class CartServices
{
    public function addToCart($productid_hidden, $quantity)
    {
        $user = Auth::user();
        $product = products::find($productid_hidden);
        // dd($product);
        dd($product->price);
        // Tính giá sản phẩm
        $price = $product->price * $quantity;
    
        // Tạo đối tượng giỏ hàng
        $cart = new Cart([
            'user_id' => $user->id,
            'product_id' => $productid_hidden,
            'quantity' => $quantity,
            'price' => $price,
            'name' => $product->name,
            'image' => $product->image,
        ]);
    
        // Lưu giỏ hàng vào cơ sở dữ liệu
        $cart->save();
    
        // Trả về đối tượng giỏ hàng
        return $cart;
    }
}
