<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\categories;
use App\Models\products;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    protected $product = null;
    public function __construct(products $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $this->middleware('user'); // Sử dụng middleware

        $user = Auth::user(); // Lấy thông tin người dùng đăng nhập

        $wishlists = Wishlist::where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(10); // Lấy danh sách yêu thích của người dùng đăng nhập
        $category = categories::where('status', 1)->get();
        $carts = cart::where('user_id', $user->id)->get(); // Lấy giỏ hàng của người dùng đăng nhập

        return view('frontend.pages.wishlist', compact('wishlists', 'category', 'carts'))->with('i');
        // $wishlists = Wishlist::orderBy('id', 'DESC')->paginate(10);
        // $category = categories::where('status', 1)->get();
        // $carts = cart::all();
        // return view('frontend.pages.wishlist', compact('wishlists', 'category', 'carts'))->with('i');
    }
    public function addWishlist(Request $request)
    {
        // dd($request->id);
        if (empty($request->id)) {
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại!');
        }
        $product = products::where('id', $request->id)->first();
        if (empty($product)) {
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại!');
        }
        // dd($product);
        $already_wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id', null)->where('product_id', $product->id)->first();
        // return $already_wishlist;
        if ($already_wishlist) {
            return back()->with('error', 'Sản phẩm đã tồn tại trong danh sách yêu thích.');
        } else {
            $wishlist = new Wishlist;
            $wishlist->user_id = auth()->user()->id;
            $wishlist->product_id = $product->id;
            $wishlist->price = $product->price;
            $wishlist->quantity = 1;
            $wishlist->amount = $wishlist->price * $wishlist->quantity;
            if ($wishlist->product->quantity < $wishlist->quantity || $wishlist->product->quantity <= 0) return back()->with('error', 'Số lượng vượt quá mức quy định.');
            $wishlist->save();
        }
        return back()->with('success', 'Thêm sản phẩm vào danh sách yêu thích thành công.');
    }

    public function wishlistDelete(Request $request)
    {
        $wishlist = Wishlist::find($request->id);
        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Đã xóa thành công.');
        }
        return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại');
    }
}
