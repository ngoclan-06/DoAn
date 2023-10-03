<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\blog;
use App\Models\comments;
use App\Models\order;
use App\Models\ProductReview;
use App\Models\products;
use App\Services\HomeAdminServices;
use App\Models\User;
use Exception;
// use Charts;
use Illuminate\Support\Facades\DB;

class HomeAdminController extends Controller
{
    protected $homeAdminServices;

    public function __construct(HomeAdminServices $homeAdminServices)
    {
        $this->homeAdminServices = $homeAdminServices;
    }
    public function index()
    {
        $CountCategory = $this->homeAdminServices->countCategories();
        $CountSubCategory = $this->homeAdminServices->countSubCategories();
        $CountProducts = $this->homeAdminServices->countProducts();
        $CountOrder = $this->homeAdminServices->countOrder();
        $CountAccountAdmin = $this->homeAdminServices->countAccountAdmin();
        $AdminActive = User::onlyTrashed()->where('role', '1')->count();
        $AdminInactive = $CountAccountAdmin - $AdminActive;
        $CountAccountCustom = User::count() - $CountAccountAdmin;
        $CustomActive = User::onlyTrashed()->where('role', '0')->count();
        $CustomInactive = $CountAccountCustom - $CustomActive;
        $order = order::all();
        $total = 0;
        foreach ($order as $item) {
            $total += $item->total;
        }
        //list review
        $reviews = ProductReview::orderBy('id', 'DESC')->paginate(20);
        $reviewCounts = ProductReview::selectRaw('products_id, count(*) as count')
            ->groupBy('products_id')
            ->pluck('count', 'products_id');
        //possts
        $commentCounts = comments::selectRaw('blog_id, count(*) as count')
            ->groupBy('blog_id')
            ->pluck('count', 'blog_id');
        $blogs = blog::all(); // lấy danh sách các blog
        //bieu do
        $dailyRevenues = DB::table('order')
            ->where('status', 'delivered')
            ->whereNull('deleted_at')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as revenue'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // Lấy doanh thu theo tháng
        $monthlyRevenues = DB::table('order')
            ->where('status', 'delivered')
            ->whereNull('deleted_at')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total) as revenue'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        return view('backend.index', compact(
            'dailyRevenues',
            'monthlyRevenues',
            'blogs',
            'commentCounts',
            'reviewCounts',
            'reviews',
            'total',
            'CountCategory',
            'CountSubCategory',
            'CountProducts',
            'CountOrder',
            'CountAccountAdmin',
            'AdminActive',
            'AdminInactive',
            'CountAccountCustom',
            'CustomActive',
            'CustomInactive',
        ));
    }
    public function profile()
    {
        $profile = Auth()->user();
        return view('backend.users.profile', compact('profile'));
    }

    public function updateProfile(UpdateProfileRequest $profileRequest, $id)
    {
        try {
            $result = $this->homeAdminServices->updateProfile($profileRequest, $id);
            if ($result) {
                return redirect()->route('home')->with('success', 'Bạn đã cập nhật thông tin tài khoản bạn thành công.');
            } else {
                return redirect()->back()->with('error', 'Cập nhật thông tin thất bại.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }
}
