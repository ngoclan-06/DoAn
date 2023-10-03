<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>

<body>
    <h1>Reset your password</h1>
    <p>Please click the following link to reset your password:</p>
    <a href="{{ route('password.reset', $token) }}">Reset Password</a>
    <p>If you did not request a password reset, you can safely ignore this email.</p>
</body>

</html>
