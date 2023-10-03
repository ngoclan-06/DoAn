<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Cart;

class CouponController extends Controller
{

    public function index()
    {
        $coupons = Coupon::orderBy('id', 'DESC')->paginate('10');
        return view('backend.coupon.index', compact('coupons'));
    }


    public function create()
    {
        return view('backend.coupon.create');
    }
    
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'code' => 'string|required',
                'type' => 'required|in:fixed,percent',
                'value' => 'required|numeric',
                'status' => 'required|in:active,inactive'
            ],
            [
                'code' => 'Vui lòng nhập mã code giảm giá.',
                'value' => 'Vui lòng nhập tỷ lệ phần trăm giảm giá.',
            ]
        );
        $data = $request->all();
        $status = Coupon::create($data);
        if ($status) {
            return redirect()->route('coupon.index')->with('success', 'Thêm mới thành công');
        } else {
            return redirect()->route('coupon.index')->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
        }
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            return view('backend.coupon.edit')->with('coupon', $coupon);
        } else {
            return view('backend.coupon.index')->with('error', 'Page not found');
        }
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);
        $this->validate($request, [
            'code' => 'string|required',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'status' => 'required|in:active,inactive'
        ]);
        $data = $request->all();

        $status = $coupon->fill($data)->save();
        if ($status) {
            return redirect()->route('coupon.index')->with('success', 'Đã cập nhật thành công.');
        } else {
            return redirect()->route('coupon.index')->with('error', 'Đã cập nhật thất bại.');
        }
    }

    public function delete($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            $status = $coupon->delete();
            if ($status) {
                return redirect()->route('coupon.index')->with('success', 'Đã xóa thành công.');
            } else {
                return redirect()->route('coupon.index')->with('error', 'Đã xóa thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Page not found');
        }
    }
}
