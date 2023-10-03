<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\cart;
use App\Models\categories;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class cartController extends Controller
{
    protected $product = null;
    public function __construct(products $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $carts = cart::orderBy('id', 'DESC')->paginate(10);
        $category = categories::where('status', 1)->get();
        $wishlists = Wishlist::all();
        return view('frontend.pages.cart', compact('carts', 'category', 'wishlists'));
    }

    public function addToCart(Request $request)
    {
        if (empty($request->id)) {
            return back()->with('error', 'Đã xảy ra lỗi! Sản phẩm không hợp lệ.');
        }
        $product = products::where('id', $request->id)->first();
        if (empty($product)) {
            return back()->with('error', 'Đã xảy ra lỗi! Sản phẩm không hợp lệ.');
        }
        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->where('product_id', $product->id)->first();
        if ($already_cart) {
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $product->price + $already_cart->amount;
            if ($already_cart->product->quantity < $already_cart->quantity || $already_cart->product->quantity <= 0) return back()->with('error', 'Stock not sufficient!.');
            $already_cart->save();
        } else {

            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = $product->price;
            $cart->quantity = 1;
            $cart->amount = $cart->price * $cart->quantity;
            if ($cart->product->quantity < $cart->quantity || $cart->product->quantity <= 0) return back()->with('error', 'Stock not sufficient!.');
            $cart->save();
            //$wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id', null)->update(['cart_id' => $cart->id]);
        }
        return back()->with('success', 'Thêm vào giỏ hàng thành công.');
    }

    public function cartUpdate(Request $request)
    {
        if ($request->quant) {
            $error = array();
            $success = '';
            foreach ($request->quant as $k => $quant) {
                $id = $request->qty_id[$k];
                $cart = Cart::find($id);
                if ($quant > 0 && $cart) {
                    if ($cart->product->quantity < $quant) {
                        return back()->with('error', 'Đã xảy ra lỗi! Số lượng mua không được vượt quá số lượng bánh của cửa hàng.');
                    }
                    $cart->quantity = ($cart->product->quantity > $quant) ? $quant  : $cart->product->quantity;
                    if ($cart->product->quantity <= 0) continue;
                    $after_price = $cart->product->price;
                    $cart->amount = $after_price * $quant;
                    $cart->save();
                    $success = 'Bạn đã cập nhật giỏ hàng thành công!';
                } else {
                    $error[] = 'Giỏ hàng không hợp lệ';
                }
            }
            return back()->with($error)->with('success', $success);
        } else {
            return back()->with('Giỏ hàng không hợp lệ!');
        }
    }

    public function cartDelete(Request $request)
    {
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            return back()->with('success', 'Bạn đã xóa sản phẩm ra khỏi giỏ hàng thành công.');
        }
        return back()->with('error', 'Đã xảy ra lỗi! Xin vui lòng thử lại.');
    }

    public function checkout()
    {
        $carts = cart::get();
        $wishlists = Wishlist::get();
        $category = categories::where('status', 1)->get();
        return view('frontend.pages.checkout', compact('carts', 'category', 'wishlists'));
    }
}
