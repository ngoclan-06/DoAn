<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận đơn hàng</title>
</head>
<body>
    <h1>Cảm ơn bạn đã đặt hàng</h1>
    <p>Dưới đây là chi tiết đơn hàng của bạn:</p>
    <p><strong>Số thứ tự:</strong> {{ $order->id }}</p>
    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
    <p><strong>Thông tin khách hàng:</strong></p>
    <ul>
        <li><strong>Tên khách hàng:</strong> {{ $order->fullname }}</li>
        <li><strong>Email:</strong> {{ $order->email }}</li>
        <li><strong>Số điện thoại:</strong> {{ $order->phone }}</li>
        <li><strong>Địa chỉ:</strong> {{ $order->address }}</li>
    </ul>
    <p><strong>Chi tiết đơn hàng:</strong></p>
    <table>
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng đơn hàng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderDetails as $item)
                <tr>
                    <td>{{ $item->products->name }}</td>
                    <td>{{ $item->products->price }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->quantity * $item->price }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total</td>
                <td>{{ $order->total }}</td>
            </tr>
        </tfoot>
    </table>
    <p><strong>Vui lòng liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi.</strong></p>
    <p><strong>Trân trọng,</strong></p>
    <p><strong>Cửa hàng HaVyBakery</strong></p>
</body>
</html>
