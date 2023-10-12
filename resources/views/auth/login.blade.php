<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trackr - Login</title>

  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="Trackr">
  <meta property="og:description" content="Inventory Management System for SABC Ltd.">
  <meta property="og:image" content="{{ asset('assets/trackr_logo_main.png') }}">
  <meta property="og:image:secure_url" content="{{ asset('assets/trackr_logo_main.png') }}">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="en_NG">

  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/trackr_favicon.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid min-vh-100 d-flex flex-column">
        <div class="row flex-grow-1" style="background-image: url('{{ asset('assets/construction_site.png') }}'); background-size: cover; background-repeat: no-repeat;">
            <!--LEFT SIDE-->
            <div class="col-md-6 d-none d-md-block">
                <div class="mt-5 ms-5">
                    <a href="{{ route('login') }}">
                        <img src="{{ asset('assets/sabc_logo.png') }}" width="180" alt="">
                    </a>
                </div>
            </div>

            <!--RIGHT SIDE-->
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div>
                    <div class="mb-5 d-flex justify-content-center d-md-none">
                        <img src="{{ asset('assets/sabc_logo.png') }}" width="180" alt="">
                    </div>

                    <div class="card shadow-lg rounded">
                        <div class="card-body px-4">
                            @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                <small>{{ session('error') }}</small>
                            </div>
                            @endif
                            <div class="">
                            <a href="{{ route('login') }}" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                <img src="{{ asset('assets/trackr_logo_main.png') }}" width="180" alt="">
                            </a>
                            <p class="text-center">SABC Limited</p>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">{{ __('Email Address') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link text-danger" href="{{ route('password.request') }}">
                                            {{ __('Forgot Password?') }}
                                        </a>
                                    @endif
                                </div>


                                <button type="submit" class="btn btn-lg btn-danger w-100  mb-4 rounded-2">
                                {{ __('Login') }}
                                </button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="{{ asset('admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
