<?php

namespace App\Http\Controllers;

use App\Services\FrontendServices;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\banners;
use App\Models\blog;
use App\Models\categories;
use App\Models\products;
use App\Models\sub_categories;
use App\Models\cart;
use App\Models\comments;
use App\Models\order;
use App\Models\order_detail;
use App\Models\Wishlist;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Coupon;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

class FrontendController extends Controller
{
    protected $frontendServices;

    public function __construct(FrontendServices $frontendServices)
    {
        $this->frontendServices = $frontendServices;
    }

    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleHandle()
    {

        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) 
        {
            return redirect('/login');
        }

        // if (explode('@', $user->email_address)[1] !== 'company.com')
        // {
        //     return redirect()->to('/');
        // }

        $existUser = User::where('email_address', $user->email)->first();

        if ($existUser) {
            auth()->login($existUser, true);
        } else {
            $newUser = new User;
            $newUser->name = $user->name;
            $newUser->email_address = $user->email;
            $newUser->google_id = $user->id;
            $newUser->image = $user->avatar;
            $newUser->save();

            auth()->login($newUser, true);
        }
        return redirect()->to('/user/view_home');
    }

    public function viewLogin()
    {
        $carts = cart::get();
        $wishlists = Wishlist::get();
        $category = categories::where('status', 1)->get();
        return view('frontend.pages.login', compact('category', 'carts', 'wishlists'));
    }

    public function login(LoginRequest $request)
    {
        $email_address = $request->email_address;
        $password = $request->password;
        $remember = $request->has('remember');
        $user = $this->frontendServices->login($email_address, $password, $remember);
        // dd($user);
        if ($user) {
            if (Auth()->user()->role == 0) {

                return redirect()->route('home-user');
            } else {
                return redirect()->back()->with('error', 'Tài khoản không thể truy cập vào trang web này!');
            }
        } else {
            return redirect()->back()->with([
                'error' => 'Email hoặc mật khẩu không đúng.'
            ]);
        }
    }
    public function logout()
    {
        $this->frontendServices->logout();
        return redirect()->route('user.view-login');
    }
    public function viewRegister()
    {
        $carts = cart::get();
        $wishlists = Wishlist::get();
        $category = categories::where('status', 1)->get();
        return view('frontend.pages.register', compact('category', 'carts', 'wishlists'));
    }
    public function register(RegisterRequest $registerRequest)
    {
        $user = $this->frontendServices->register($registerRequest);
        if ($user) {
            return redirect()->route('user.view-login')->with('success', 'Bạn đã đăng ký tài khoản thành công.');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra vui lòng thử lại!');
        }
    }
    public function index()
    {

        $banners = banners::where('status', 1)->whereNull('deleted_at')->limit(3)->get();
        $products = products::where('status', 1)->whereNull('deleted_at')->limit(8)->get();
        $hotProducts = products::inRandomOrder()->where('status', 1)->whereNull('deleted_at')->limit(8)->get();
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        $blogs = blog::where('status', 1)->whereNull('deleted_at')->limit(3)->get();
        if (Auth()->user()) {
            $carts = cart::where('user_id', Auth()->user()->id)->get();
            $wishlists = Wishlist::where('user_id', Auth()->user()->id)->get();
            return view('frontend.index', compact('banners', 'products', 'hotProducts', 'category', 'blogs', 'carts', 'wishlists'));
        }
        return view('frontend.index', compact('banners', 'products', 'hotProducts', 'category', 'blogs'));
    }

    public function productDetail($id)
    {
        $productDetail = products::where('id', $id)->first();
        $category = categories::where('status', 1)->get();
        $subcate = sub_categories::where('status', 1)->where('id', $productDetail->sub_categories_id)->first()->name;
        $relatedProducts = products::where('sub_categories_id', $productDetail->sub_categories_id)
            ->where('id', '!=', $id)->limit(3)->get();
        $carts = cart::all();
        $wishlists = Wishlist::all();
        return view('frontend.pages.product_detail', compact('productDetail', 'category', 'subcate', 'relatedProducts', 'carts', 'wishlists'));
    }

    public function productList()
    {
        $now = now();
        $products = products::query()->where('expiry', '>', $now);

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            $cat_ids = sub_categories::select('id')->pluck('id')->toArray();
            $products->whereIn('sub_categories_id', $cat_ids)->paginate;
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'name') {
                $products = $products->where('status', '1')->orderBy('name', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);

            $products->whereBetween('price', $price);
        }

        $recent_products = products::where('status', '1')->whereNull('deleted_at')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', '1')->whereNull('deleted_at')->paginate($_GET['show']);
        } else {
            $products = $products->where('status', '1')->whereNull('deleted_at')->paginate(6);
        }
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        $carts = cart::all();
        $wishlists = Wishlist::all();
        return view('frontend.pages.product-lists', compact('products', 'recent_products', 'category', 'carts', 'wishlists'));
    }

    public function productGrid()
    {
        $products = products::query();

        if (!empty($_GET['category'])) {

            $cat_ids = sub_categories::select('id')->whereNull('deleted_at')->pluck('id')->toArray();

            $products->whereIn('cat_id', $cat_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', '1')->whereNull('deleted_at')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->whereNull('deleted_at')->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            $products->whereBetween('price', $price);
        }

        $recent_products = products::where('status', '1')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', '1')->whereNull('deleted_at')->paginate($_GET['show']);
        } else {
            $products = $products->where('status', '1')->whereNull('deleted_at')->paginate(9);
        }
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        $carts = cart::all();
        $wishlists = Wishlist::all();
        return view('frontend.pages.product-grids', compact('products', 'recent_products', 'category', 'carts', 'wishlists'));
    }

    public function productCate($cateId)
    {
        $products = categories::find($cateId)->products;
        $recent_products = products::where('status', '1')->whereNull('deleted_at')->orderBy('id', 'DESC')->limit(3)->get();

        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        $carts = cart::all();
        $wishlists = Wishlist::all();
        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids', compact('products', 'recent_products', 'category', 'carts', 'wishlists'));
        } else {
            return view('frontend.pages.product-lists', compact('products', 'recent_products', 'category', 'carts', 'wishlists'));
        }
    }

    public function productSubCate($subCateId)
    {
        $products = sub_categories::find($subCateId)->products;
        $recent_products = products::where('status', '1')->whereNull('deleted_at')->orderBy('id', 'DESC')->limit(3)->get();

        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        $carts = cart::all();
        $wishlists = Wishlist::all();
        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids', compact('products', 'recent_products', 'category', 'carts', 'wishlists'));
        } else {
            return view('frontend.pages.product-lists', compact('products', 'recent_products', 'category', 'carts', 'wishlists'));
        }
    }

    public function productFilter(Request $request)
    {
        $data = $request->all();
        $showURL = "";
        if (!empty($data['show'])) {
            $showURL .= '&show=' . $data['show'];
        }

        $sortByURL = '';
        if (!empty($data['sortBy'])) {
            $sortByURL .= '&sortBy=' . $data['sortBy'];
        }


        $priceRangeURL = "";
        if (!empty($data['price_range'])) {
            $priceRangeURL .= '&price=' . $data['price_range'];
        }
        if (request()->is('e-shop.loc/product-grids')) {
            return redirect()->route('product-grids',  $priceRangeURL . $showURL . $sortByURL);
        } else {
            return redirect()->route('product-lists',  $priceRangeURL . $showURL . $sortByURL);
        }
    }

    public function productSearch(Request $request)
    {
        // $now = now();
        // ->where('expiry', '>', $now)
        $recent_products = products::where('status', '1')->orderBy('id', 'DESC')->whereNull('deleted_at')->limit(3)->get();
        $products = products::whereNull('deleted_at')->orwhere('name', 'like', '%' . $request->search . '%')
            ->orwhere('description', 'like', '%' . $request->search . '%')
            ->orwhere('price', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate('9');
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        $carts = cart::all();
        $wishlists = Wishlist::all();
        return view('frontend.pages.product-grids', compact('products', 'recent_products', 'category', 'carts', 'wishlists'));
    }

    public function orderIndex()
    {
        $carts = cart::all();
        $wishlists = Wishlist::all();
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        $orders = order::orderByDesc('id')->where('user_id', Auth()->user()->id)->whereNull('deleted_at')->get();
        $orderDetails = [];
        if ($orders) {
            foreach ($orders as $order) {

                $orderDetail = order_detail::where('order_id', $order->id)->whereNull('deleted_at')->first();
                $orderDetails[] = $orderDetail;
            }
            return view('frontend.pages.order', compact('orders', 'orderDetails', 'category', 'carts', 'wishlists'));
        } else {
            return redirect()->back()->with('error', 'Hiện tại bạn chưa có đơn hàng nào.');
        }
    }

    public function blog()
    {
        $blogs = blog::where('status', 1)->whereNull('deleted_at')->paginate(10);
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        $carts = cart::all();
        $wishlists = Wishlist::all();
        $recent_blogs = blog::orderBy('id', 'DESC')->where('status', 1)->whereNull('deleted_at')->limit(3)->get();
        return view('frontend.pages.blog', compact('blogs', 'category', 'recent_blogs', 'carts', 'wishlists'));
    }

    public function blogDetail($id)
    {
        $blog = blog::find($id);
        $comments = comments::where('blog_id', $blog->id)->paginate(10);
        $carts = cart::all();
        $wishlists = Wishlist::all();
        $recent_blogs = blog::orderBy('id', 'DESC')->where('status', 1)->whereNull('deleted_at')->limit(3)->get();
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        return view('frontend.pages.blog-detail', compact('blog', 'category', 'comments', 'recent_blogs', 'carts', 'wishlists'));
    }

    public function contact()
    {
        $carts = cart::all();
        $wishlists = Wishlist::all();
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        return view('frontend.pages.contact', compact('category', 'carts', 'wishlists'));
    }
    public function aboutUs()
    {
        $carts = cart::all();
        $wishlists = Wishlist::all();
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        return view('frontend.pages.about-us', compact('category', 'carts', 'wishlists'));
    }

    public function cancleOrder($id)
    {
        $order = order::find($id);
        if ($order->status == 'new') {
            $order->update([
                'status' => 'cancel',
            ]);
            foreach ($order->order_detail as $orderDetail) {
                $product = products::find($orderDetail->products_id);
                $product->quantity += $orderDetail->quantity;
                $product->save();
            }
            return back()->with('success', 'Bạn đã hủy thành công đơn hàng này.');
        } else {
            return back()->with('error', 'Bạn không thể hủy đơn hàng này.');
        }
    }

    public function profile()
    {
        $profile = Auth()->user();
        $carts = cart::all();
        $wishlists = Wishlist::all();
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        return view('frontend.pages.profiles', compact('profile', 'category', 'carts', 'wishlists'));
    }
    public function updateProfile(UpdateProfileRequest $profileRequest, $id)
    {
        try {
            $result = $this->frontendServices->updateProfile($profileRequest, $id);
            if ($result) {
                return redirect()->route('home-user')->with('success', 'Bạn đã cập nhật thông tin tài khoản bạn thành công.');
            } else {
                return redirect()->back()->with('error', 'Cập nhật thông tin thất bại.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function userChangePassword()
    {
        $carts = cart::all();
        $wishlists = Wishlist::all();
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        return view('frontend.pages.changepassword', compact('category', 'carts', 'wishlists'));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');

        $result = $this->frontendServices->changePassword($currentPassword, $newPassword);

        if ($result) {
            return redirect()->route('home-user')->with('success', 'Thay đổi mật khẩu thành công.');
        } else {
            return redirect()->back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }
    }

    public function couponStore(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();
        if (!$coupon) {
            return back()->with('error', 'Mã giảm giá không hợp lệ, vui lòng thử lại');
        }
        if ($coupon) {
            $total_price = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->sum('price');
            session()->put('coupon', [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'value' => $coupon->discount($total_price)
            ]);
            return redirect()->back()->with('success', 'Đã áp dụng mã giảm giá thành công.');
        }
    }

    public function sendCoupon(Request $request)
    {
        $mail = $request->email;
        $coupon = Coupon::where('status', 'active')->inRandomOrder()->first();
        Mail::send('frontend.mail.coupon', compact('coupon'), function ($message) use ($mail) {
            $message->to($mail);
            $message->subject('Discount code');
        });

        return redirect()->back()->with('success', 'Bạn đã đăng ký thành công.');
    }
}
