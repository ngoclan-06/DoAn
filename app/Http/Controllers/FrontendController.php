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
use App\Models\ProductReview;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
    //     $carts = cart::get();
    //     $wishlists = Wishlist::get();
    //     $category = categories::where('status', 1)->get();
        return view('frontend.pages.login');
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
        $user = auth()->user();
        
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
        // $this->middleware('user'); // Sử dụng middleware
        $user = Auth::user(); // Lấy thông tin người dùng đăng nhập

        $carts = cart::where('user_id', $user?->id)->get(); // Lấy giỏ hàng của người dùng đăng nhập
        $wishlists = Wishlist::where('user_id', $user?->id)->orderBy('id', 'DESC')->paginate(10); // Lấy danh sách yêu thích của người dùng đăng nhập
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        $now = now();
        $productDetail = products::where('id', $id)->first();
        $reviews = ProductReview::where('products_id', $productDetail->id)->where('status', 'active')->get();
        $subcate = sub_categories::where('status', 1)->where('id', $productDetail->sub_categories_id)->first()->name;
        $relatedProducts = products::where('sub_categories_id', $productDetail->sub_categories_id)
            ->where('id', '!=', $id)->limit(3)->get();
        return view('frontend.pages.product_detail', compact('productDetail', 'category', 'subcate', 'relatedProducts', 'carts', 'wishlists'));
    }

    public function productList()
    {
        // $this->middleware('user'); // Sử dụng middleware

        $user = Auth::user();
        $now = now();
        $products = products::query()->where('expiry', '>', $now);

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            $catIds = sub_categories::whereIn('slug', $slug)->pluck('id')->toArray();
            $products->whereIn('sub_categories_id', $catIds);
        }

        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'name') {
                $products->where('status', '1')->orderBy('name', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            $products->whereBetween('price', $price);
        }

        $recent_products = products::where('status', '1')->where('quantity', '>', 0)->whereNull('deleted_at')->orderBy('id', 'DESC')->limit(3)->get();

        // Sort by number
        $perPage = (!empty($_GET['show'])) ? $_GET['show'] : 6;
        $products = $products->where('status', '1')->where('quantity', '>', 0)->whereNull('deleted_at')->paginate($perPage);

        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        $carts = cart::where('user_id', $user?->id)->get(); // Lấy giỏ hàng của người dùng đăng nhập
        $wishlists = Wishlist::where('user_id', $user?->id)->get(); //

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
        // $this->middleware('user'); // Sử dụng middleware

        $user = Auth::user(); // Lấy thông tin người dùng đăng nhập

        $products = categories::find($cateId)
            ->products()
            ->where('status', '1')
            ->where('quantity', '>', 0) // Thêm điều kiện lọc quantity > 0
            ->get();
    
        $recent_products = products::where('status', '1')
            ->whereNull('deleted_at')
            ->where('quantity', '>', 0) // Thêm điều kiện lọc quantity > 0
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
    
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        $carts = cart::where('user_id', $user?->id)->get();
        $wishlists = Wishlist::where('user_id', $user?->id)->get();
    
        return view('frontend.pages.product-lists', compact('products', 'recent_products', 'category', 'carts', 'wishlists'));
    }

    public function productSubCate($subCateId)
    {
        // $this->middleware('user'); // Sử dụng middleware
        $user = Auth::user(); // Lấy thông tin người dùng đăng nhập

        $carts = cart::where('user_id', $user?->id)->get(); // Lấy giỏ hàng của người dùng đăng nhập
        $wishlists = Wishlist::where('user_id', $user?->id)->orderBy('id', 'DESC')->paginate(10); // Lấy danh sách yêu thích của người dùng đăng nhập
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        $products = sub_categories::find($subCateId)->products->where('status', '1')->where('quantity', '>', 0);
        $recent_products = products::where('status', '1')->where('quantity', '>', 0)->whereNull('deleted_at')->orderBy('id', 'DESC')->limit(3)->get();
        // if (request()->is('e-shop.loc/product-grids')) {
        //     return view('frontend.pages.product-grids', compact('products', 'recent_products', 'category', 'carts', 'wishlists'));
        // } else {
            return view('frontend.pages.product-lists', compact('products', 'recent_products', 'category', 'carts', 'wishlists'));
        // }
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
        // if (request()->is('e-shop.loc/product-grids')) {
        //     return redirect()->route('product-grids',  $priceRangeURL . $showURL . $sortByURL);
        // } else {
            return redirect()->route('product-lists',  $priceRangeURL . $showURL . $sortByURL);
        // }
    }

    public function productSearch(Request $request)
    {
        // $this->middleware('user'); // Sử dụng middleware
        $user = Auth::user(); // Lấy thông tin người dùng đăng nhập

        $carts = cart::where('user_id', $user?->id)->get(); // Lấy giỏ hàng của người dùng đăng nhập
        $wishlists = Wishlist::where('user_id', $user?->id)->orderBy('id', 'DESC')->paginate(10); // Lấy danh sách yêu thích của người dùng đăng nhập
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        // $category = categories::where('status', 1)
        //     ->whereNull('deleted_at')
        //     ->where('name', 'like', '%' . $request->search . '%')
        //     ->get();
        $recent_products = products::where('status', '1')->where('quantity', '>', 0)->orderBy('id', 'DESC')->whereNull('deleted_at')->limit(3)->get();
        $products = products::where('status', 1)->where('quantity', '>', 0)
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('price', 'like', '%' . $request->search . '%');
            })
            ->orderBy('id', 'DESC')
            ->whereNull('deleted_at')
            ->paginate(9);
        return view('frontend.pages.product-lists', compact('products', 'recent_products', 'category', 'carts', 'wishlists'));
    }

    public function orderIndex()
    {
        // $this->middleware('user'); // Sử dụng middleware
        $user = Auth::user(); // Lấy thông tin người dùng đăng nhập

        $carts = cart::where('user_id', $user?->id)->get(); // Lấy giỏ hàng của người dùng đăng nhập
        $wishlists = Wishlist::where('user_id', $user?->id)->orderBy('id', 'DESC')->paginate(10); // Lấy danh sách yêu thích của người dùng đăng nhập
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
        // $this->middleware('user'); // Sử dụng middleware
        $user = Auth::user();

        $blogs = blog::where('status', 1)->whereNull('deleted_at')->paginate(10);
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();
        $carts = cart::where('user_id', $user?->id)->get();
        $wishlists = Wishlist::where('user_id', $user?->id)->orderBy('id', 'DESC')->paginate(10);
        $recent_blogs = blog::orderBy('id', 'DESC')->where('status', 1)->whereNull('deleted_at')->limit(3)->get();
        return view('frontend.pages.blog', compact('blogs', 'category', 'recent_blogs', 'carts', 'wishlists'));
    }

    public function blogDetail($id)
    {
        // $this->middleware('user'); // Sử dụng middleware
        $user = Auth::user();

        $blog = blog::find($id);
        $comments = comments::where('blog_id', $blog->id)->where('status', 'active')->paginate(10);
        $carts = cart::where('user_id', $user?->id)->get();
        $wishlists = Wishlist::where('user_id', $user?->id)->orderBy('id', 'DESC')->paginate(10);
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
        // $this->middleware('user'); // Sử dụng middleware
        $user = Auth::user(); // Lấy thông tin người dùng đăng nhập

        $carts = cart::where('user_id', $user?->id)->get(); // Lấy giỏ hàng của người dùng đăng nhập
        $wishlists = Wishlist::where('user_id', $user?->id)->orderBy('id', 'DESC')->paginate(10); // Lấy danh sách yêu thích của người dùng đăng nhập
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
        // $this->middleware('user');
        $profile = Auth()->user();
        $carts = cart::where('user_id', $profile->id)->get();
        $wishlists = Wishlist::where('user_id', $profile->id)->orderBy('id', 'DESC')->paginate(10);
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
        // $this->middleware('user'); // Sử dụng middleware

        $user = Auth::user(); // Lấy thông tin người dùng đăng nhập

        $carts = cart::where('user_id', $user?->id)->get(); // Lấy giỏ hàng của người dùng đăng nhập
        $wishlists = Wishlist::where('user_id', $user?->id)->orderBy('id', 'DESC')->paginate(10); // Lấy danh sách yêu thích của người dùng đăng nhập
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

    public function historyOrder()
    {
        // Đảm bảo người dùng đã đăng nhập
        $user = Auth::user();

        if (!$user) {
            // Xử lý khi người dùng chưa đăng nhập, ví dụ chuyển hướng đến trang đăng nhập
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem lịch sử đơn hàng.');
        }

        $carts = cart::where('user_id', $user->id)->get();
        $wishlists = Wishlist::where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(10);
        $category = categories::where('status', 1)->whereNull('deleted_at')->get();

        // Lấy danh sách đơn hàng của người dùng đăng nhập
        $orders = Order::where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(10);

        // Kiểm tra trùng lặp email trước khi hiển thị đơn hàng
        $uniqueEmails = Order::where('user_id', $user->id)->distinct()->pluck('email');

        return view('frontend.pages.history-order', compact('category', 'carts', 'wishlists', 'orders', 'uniqueEmails'))->with('i');
    }

    public function viewOrder($id)
    {

         // Đảm bảo người dùng đã đăng nhập
         $user = Auth::user();

         if (!$user) {
             // Xử lý khi người dùng chưa đăng nhập, ví dụ chuyển hướng đến trang đăng nhập
             return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem lịch sử đơn hàng.');
         }
 
         $carts = cart::where('user_id', $user->id)->get();
         $wishlists = Wishlist::where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(10);
         $category = categories::where('status', 1)->whereNull('deleted_at')->get();
 
         // Lấy danh sách đơn hàng của người dùng đăng nhập
        //  $orders = Order::where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(10);
 
         // Kiểm tra trùng lặp email trước khi hiển thị đơn hàng
        //  $uniqueEmails = Order::where('user_id', $user->id)->distinct()->pluck('email');
        $order = order::find($id);
        $orderDetails = order_detail::where('order_id', $id)->get();
 
         return view('frontend.pages.view-order', compact('category', 'carts', 'wishlists', 'order', 'orderDetails'))->with('i');
    }
}
