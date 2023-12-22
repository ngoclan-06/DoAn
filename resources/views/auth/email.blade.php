<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>

<body>
    <h1>Đặt lại mật khẩu của bạn</h1>
    <p>Vui lòng nhấp vào liên kết sau để đặt lại mật khẩu của bạn:</p>
    <a href="{{ route('password.reset', $token) }}">Đặt lại mật khẩu</a>
    <p>Nếu bạn không yêu cầu đặt lại mật khẩu, bạn có thể yên tâm bỏ qua email này.</p>
</body>

</html>
