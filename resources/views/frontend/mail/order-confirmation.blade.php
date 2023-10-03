<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Thank you for your order!</h1>
    <p>Here are the details of your order:</p>
    <p><strong>Order Number:</strong> {{ $order->id }}</p>
    <p><strong>Order Date:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
    <p><strong>Customer Information:</strong></p>
    <ul>
        <li><strong>Name:</strong> {{ $order->fullname }}</li>
        <li><strong>Email:</strong> {{ $order->email }}</li>
        <li><strong>Phone:</strong> {{ $order->phone }}</li>
        <li><strong>Address:</strong> {{ $order->address }}</li>
    </ul>
    <p><strong>Order Details:</strong></p>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
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
    <p><strong>Please contact us if you have any questions.</strong></p>
    <p><strong>Best regards,</strong></p>
    <p><strong>The Store HaVyBakery</strong></p>
</body>
</html>
