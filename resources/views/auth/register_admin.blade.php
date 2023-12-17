<!DOCTYPE html>
<html lang="en">

<head>
    <title>HaVyBakery || Register Page</title>
    @include('backend.layouts.head')

    <style type="text/css">
        *{
            padding: 0;
            margin: 0;
            font-family: 'poppins', sans-serif;
        }
        section{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            background: #00ff00;
            background: url({{ asset('image/banh11.jpg') }})no-repeat;
            background-position: center;
            background-size: cover;
        }
        .form-box{
            position: relative;
            width: 400px;
            height: 500px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 1.5);
            border-radius: 20px;
            backdrop-filter: blur(25px);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        h2{
            font-size: 4em;
            color: #fff;
            text-align: center;
        }
        h4{
            font-size: 2em;
            color: #fff;
            text-align: center;
        }
        .inputbox{
            position: relative;
            margin: 30px 0;
            width: 310px;
            border-bottom: 2px solid #fff;
        }
        .inputbox label{
            position: absolute;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            color: #fff;
            font-size: 1em;
            pointer-events: none;
            transition: .5s
        }
        input:focus ~ label,
        input:valid ~ label{
            top: -5px;
        }
        .inputbox input{
            width: 100%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 1em;
            padding: 0 35px 0 5px;
            color: #fff;
        }
        .inputbox ion-icon{
            position: absolute;
            right: 8px;
            color: #fff;
            font-size: 1.2em;
            top: 20px;
        }
        .forget{
            margin: -15px 0 15px;
            font-size: .9em;
            color: #fff;
            display: flex;
            justify-content: center;
        }
        .forget label input{
            margin-right: 3px;
        }
        .forget label a{
            color: #fff;
            text-decoration: none;
        }
        .forget label a:hover{
            text-decoration: underline;
        }
        .forget a{
            text-decoration: none;
            color: #ffc107bf;
            /* font-weight: 600; */
        }
        .forget a:hover{
            text-decoration: underline;
            color: #0dfd4c;
        }
        button{
            width: 100%;
            height: 40px;
            border-radius: 40px;
            background: #fff;
            border: none;
            outline: none;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
        }
        .register{
            font-size: .9em;
            color: #fff;
            text-align: center;
            margin: 25px 0 10px;
        }
        .register p a{
            text-decoration: none;
            color: #ffc107bf;
            font-weight: 600;
        }
        .register p a:hover{
            text-decoration: underline;
            color: #0dfd4c;
        }
        /**/
    </style>
</head>

<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <h4>ĐĂNG KÝ</h4>
                        <div class="inputbox">
                            <ion-icon name="name-outline"></ion-icon>
                            <input type="name" name="name" @error('name') is-invalid @enderror value="{{ old('name') }}" required>
                            <label for="">Tên</label>
                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="inputbox">
                            <ion-icon name="mail-outline"></ion-icon>
                            <input type="email" name="email_address" @error('email_address') is-invalid @enderror value="{{ old('email_address') }}" required>
                            <label for="">Email</label>
                            @error('email_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
    
                        <div class="inputbox">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                            <input type="password" name="password" @error('password') is-invalid @enderror value="{{ old('password') }}" required>
                            <label for="">Mật khẩu</label>
                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="inputbox">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                            <input type="password" name="password_confirmation" @error('password_confirmation') is-invalid @enderror value="{{ old('password_confirmation') }}" required>
                            <label for="">Mật khẩu nhập lại</label>
                            @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <button class="btn btn-primary" type="submit" name="submit">Register</button>
                        <a href="{{route('view-login')}}" style="margin-left:127px; color:#fff; margin-top:3px;">Đăng nhập</a>
                        {{ csrf_field() }}
                    </form>
                    @if (isset($errors))
                    <p style="color:rgb(255, 0, 0); font-size: 8.5px;">
                        @foreach ($errors->all() as $error)
                            {!! $error !!}<br/>
                        @endforeach
                    </p>
                    @endif
                    @if (isset($message))
                        <p style="color:rgb(72, 0, 255);">
                            {{ $message }}
                        </p>
                    @endif 
                </div>
            </div> 
            </div>
        </div>
    </section>
</body>

</html>
