<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use Illuminate\Http\Request;
use App\Models\cart;
use App\Models\order;
use App\Models\order_detail;
use App\Models\payment;
use App\Models\products;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\categories;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function momo(Request $request)
    {
        // dd($request);
        // $carts = cart::where('user_id', Auth()->user()->id)->get();
        // // dd($carts);
        // foreach ($carts as $item) {
        //     $product = products::find($item->product_id);
        //     $product->quantity -= $item->quantity;
        //     $product->save();
        //     $item->delete();
        // }
        if (empty(Cart::where('user_id', auth()->user()->id)->where('order_id', null)->first())) {
            return back()->with('error', 'Đã xảy ra lỗi! Giỏ hàng của bạn đang rỗng.');
        }
        $cart = new cart();
        //create payment
        $payment = payment::create([
            'payment_method' => 'Momo',
            'payment_status' => 'paid',
        ]);
        //create order
        $order = order::create([
            // 'status' => 'new',
            // 'total' => $cart->totalCartPrice(),
            // 'date' => now(),
            // 'fullname' => 'Hà Thị Ngọc Lan',
            // 'email' => 'hangoclan1710@gmail.com',
            // 'address' => 'Vĩnh Phúc',
            // 'phone' => '0985479172',
            // 'user_id' => Auth()->user()->id,
            // 'payment_id' => $payment->id,

            'status' => 'new',
            'total' => $cart->totalCartPrice(),
            'date' => now(),
            'fullname' => Auth()->user()->name,
            'email' => Auth()->user()->email_address,
            'address' => 'Vĩnh Phúc' ?? Auth()->user()->address,
            'phone' => '0985479172' ?? Auth()->user()->phone,
            'user_id' => Auth()->user()->id,
            'payment_id' => $payment->id,
        ]);
        //create order detail
        foreach ($cart->getAllCart() as $product) {
            // Kiểm tra nếu sản phẩm thuộc người dùng đăng nhập
            if ($product->user_id == Auth()->user()->id) {
                $orderDetail = order_detail::create([
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'products_id' => $product->product_id,
                    'order_id' => $order->id,
                ]);
            }
        }
        //send mail
        $user = $order->user;
        $orderDetails = order_detail::where('order_id', $order->id)->get();
        
        // Mail::send('frontend.mail.order-confirmation', compact('user', 'order', 'orderDetails'), function ($message) use ($user) {
        //     $message->to($user->email_address, $user->name);
        //     $message->subject('Order Confirmation');
        // });

        cart::where('user_id', Auth()->user()->id)->delete();
        foreach ($order->order_detail as $orderDetail) {
            $product = products::find($orderDetail->products_id);
            $product->quantity -= $orderDetail->quantity;
            $product->save();
        }

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = (int)$request->total;
        // dd($amount);
        $orderId = time() . "";
        $redirectUrl = "http://127.0.0.1:8000/user/view_home";
        $ipnUrl = "http://127.0.0.1:8000/user/view_home";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        // dd($result);
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there
        return redirect()->to($jsonResult['payUrl']);

        // header('Location: ' . $jsonResult['payUrl']);
    }

    public function store(Request $request)
    {
        $rules = [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ];
    
        // Custom validation messages
        $messages = [
            'fullname.required' => 'Vui lòng nhập họ tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
        ];
    
        // Validate the request
        $request->validate($rules, $messages);
    
        if (empty(Cart::where('user_id', auth()->user()->id)->where('order_id', null)->first())) {
            return back()->with('error', 'Đã xảy ra lỗi! Giỏ hàng của bạn đang rỗng.');
        }
    
        $cart = new cart();
    
        // Tạo thanh toán
        if ($request->payment_method == 'paypal') {
            $payment_method = 'paypal';
            $payment_status = 'paid';
        } else {
            $payment_method = 'cod';
            $payment_status = 'Unpaid';
        }
    
        $payment = payment::create([
            'payment_method' => $payment_method,
            'payment_status' => $payment_status,
        ]);
    
        // Tạo đơn hàng
        $order = order::create([
            'status' => 'new',
            'total' => $cart->totalCartPrice(),
            'date' => now(),
            'fullname' => $request->fullname,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'user_id' => Auth()->user()->id,
            'payment_id' => $payment->id,
        ]);
    
        // Tạo chi tiết đơn hàng
        foreach ($cart->getAllCart() as $product) {
            // Kiểm tra nếu sản phẩm thuộc người dùng đăng nhập
            if ($product->user_id == Auth()->user()->id) {
                $orderDetail = order_detail::create([
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'products_id' => $product->product_id,
                    'order_id' => $order->id,
                ]);
            }
        }
    
        // Gửi email
        $user = $order->user;
        $orderDetails = order_detail::where('order_id', $order->id)->get(); // Lấy ra chi tiết đơn hàng
        Mail::send('frontend.mail.order-confirmation', compact('user', 'order', 'orderDetails'), function ($message) use ($user) {
            $message->to($user->email_address, $user->name);
            $message->subject('Order Confirmation');
        });
    
        // Xóa giỏ hàng
        cart::where('user_id', Auth()->user()->id)->delete();
    
        // Giảm số lượng sản phẩm trong kho
        foreach ($orderDetails as $orderDetail) {
            $product = products::find($orderDetail->products_id);
            $product->quantity -= $orderDetail->quantity;
            $product->save();
        }
    
        return redirect()->route('home-user')->with('success', 'Bạn đã đặt hàng thành công.');
    }
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);
        return view('backend.order.index')->with('orders', $orders)->with('i');
    }
    public function show($id)
    {
        $order = order::find($id);
        $orderDetails = order_detail::where('order_id', $id)->get();
        return view('backend.order.show', compact('order', 'orderDetails'))->with('i');
    }

    public function pdf($id)
    {
        $order = Order::find($id);
        $orderDetails = order_detail::where('order_id', $id)->get();
        $file_name = $order->id . '-' . $order->fullname . '.pdf';
        $pdf = PDF::loadview('backend.order.pdf', ['order' => $order, 'orderDetails' => $orderDetails]);
        return $pdf->download($file_name);
    }
    public function edit($id)
    {
        $order = order::find($id);
        return view('backend.order.edit', compact('order'));
    }
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $this->validate($request, [
            'status' => 'required|in:new,process,delivered,cancel'
        ]);
        $order->update([
            'status' => $request->status,
        ]);
        // if ($request->status == 'delivered') {
        //     foreach ($order->order_detail as $orderDetail) {
        //         $product = products::find($orderDetail->products_id);
        //         $product->quantity -= $orderDetail->quantity;
        //         $product->save();
        //     }
        // }
        if ($order) {
            return redirect()->route('order.index')->with('success', 'Successfully updated order');
        } else {
            return redirect()->back()->with('error', 'Error while updating order');
        }
    }

    public function delete($id)
    {
        $order = order::find($id);
        if ($order && $order->status != 'delivered') {
            $order->forceDelete();
            payment::where('id', $order->paument_id)->forceDelete();
            return redirect()->back()->with('success', 'Bạn đã xóa đơn hàng thành công.');
        } else {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra. Không thể xóa đơn hàng này.');
        }
    }
    public function incomeChart(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;
        // dd($year);
        $items = Order::whereYear('created_at', $year)->where('status', 'delivered')->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
        // dd($items);
        $result = [];
        foreach ($items as $month => $item_collections) {
            foreach ($item_collections as $item) {
                $amount = $item->sum('total');
                // dd($amount);
                $m = intval($month);
                return $m;
                // dd($m);
                isset($result[$m]) ? $result[$m] += $amount : $result[$m] = $amount;
            }
        }
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = (!empty($result[$i])) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
