<!DOCTYPE html>
<html lang="en">

<head>
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
        background: url({{ asset('image/banh1.jpg') }})no-repeat;
        background-position: center;
        background-size: cover;
    }
    /**/
  </style>
</head>

<body>
  <section>
    <div class="container">

      <!-- Outer Row -->
      <div class="row justify-content-center">

        <div class="col-xl-6 col-lg-12 col-md-9">

          <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
              <!-- Nested Row within Card Body -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="p-5">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-2">QUÊN MẬT KHẨU</h1>
                      <p class="mb-4">Chỉ cần nhập địa chỉ email của bạn dưới đây và chúng tôi sẽ gửi cho bạn một liên kết để đặt lại mật khẩu của bạn!</p>
                    </div>
                      @if (session('status'))
                          <div class="alert alert-success" role="alert">
                              {{ session('status') }}
                          </div>
                      @endif
                    <form class="user"  method="POST" action="{{ route('password.email') }}">
                      @csrf
                      <div class="form-group">
                        <input type="email" class="form-control form-control-user @error('email_address') is-invalid @enderror" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email_address" value="{{ old('email') }}">
                          @error('email_address')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                      <button type="submit" class="btn btn-primary btn-user btn-block">
                        Đặt lại mật khẩu
                      </button>
                    </form>
                    <hr>
                    <div class="text-center">
                      <a class="small" href="{{route('view-login')}}">Bạn đã có tài khoản? Đăng nhập!</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

    </div>
</section>

</body>

</html>
