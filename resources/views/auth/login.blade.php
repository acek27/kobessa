<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KOBESSA | Login</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/form-elements.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="{{asset('assets/ico/favicon.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="{{asset('assets/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="{{asset('assets/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
          href="{{asset('assets/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('assets/ico/apple-touch-icon-57-precomposed.png')}}">

</head>

<body>

<!-- Top content -->
<div class="top-content">
    <div class="container">

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 text">
                <h1>KOBESSA</h1>
                <div class="description">
                    <p>
                        Aplikasi Ekonomi Kebersamaan Kabupaten Situbondo
                    </p>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 show-forms">
                {{--                    	<span class="show-login-form">Login</span>--}}
            </div>
        </div>

        <div class="row register-form">

        </div>

        <div class="row login-form active" style="display: block!important;background: #1c606a;opacity: 80%">
            <div class="col-sm-4 col-sm-offset-1">
                <form role="form" action="{{ route('login') }}" method="post" class="l-form" style="padding-top: 30%">
                    @csrf
                    <div class="form-group">
                        <label class="sr-only" for="email">Username</label>
                        <input type="text" name="email" placeholder="Username..."
                               class="l-form-username form-control @error('email') is-invalid @enderror" id="email"
                               value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="password">Password</label>
                        <input type="password" name="password" placeholder="Password..."
                               class="l-form-password form-control @error('password') is-invalid @enderror"
                               id="password" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn">Sign in!</button>
                </form>
                {{--                <div class="social-login">--}}
                {{--                    <p>Or login with:</p>--}}
                {{--                    <div class="social-login-buttons">--}}
                {{--                        <a class="btn btn-link-1" href="#"><i class="fa fa-facebook"></i></a>--}}
                {{--                        <a class="btn btn-link-1" href="#"><i class="fa fa-twitter"></i></a>--}}
                {{--                        <a class="btn btn-link-1" href="#"><i class="fa fa-google-plus"></i></a>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
            <div class="col-sm-6 forms-right-icons">
                <div class="row">
                    <div class="col-sm-2 icon"><i class="fa fa-calendar"></i></div>
                    <div class="col-sm-10">
                        <h3>Penjadwalan Irigasi</h3>
                        <p>Memberikan informasi kepada Petani tentang jadwal aliran daerah irigasi se-Kabupaten
                            Situbondo.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 icon"><i class="fa fa-leaf"></i></div>
                    <div class="col-sm-10">
                        <h3>Penjadwalan Masa Tanam dan Panen</h3>
                        <p>Memberikan Informasi mengenai rencana Jadwal Tanam dan Jadwal Panen Petani se-Kabupaten
                            Situbondo.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 icon"><i class="fa fa-map"></i></div>
                    <div class="col-sm-10">
                        <h3>Pemetaan Lahan Pertanian</h3>
                        <p>Memetakan lokasi lahan petani Situbondo untuk memberikan informasi yang dibutuhkan.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 icon"><i class="fa fa-line-chart"></i></div>
                    <div class="col-sm-10">
                        <h3>Monitoring Budidaya Petani</h3>
                        <p>Membantu memonitoring kegiatan budidaya petani oleh PPL sehingga budidaya berjalan sesuai SOP yang telah diterapkan dan petani dapat panen secara maksimal.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">

            <div class="col-sm-8 col-sm-offset-2">
                <div class="footer-border"></div>
                © 2019 Copyright: <a href="https://situbondokab.go.id"
                                     target="_blank"> KOBESSA | Kabupaten Situbondo </a>

            </div>

        </div>
    </div>
</footer>

<!-- Javascript -->
<script src="{{asset('assets/js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.backstretch.min.js')}}"></script>
<script src="{{asset('assets/js/scripts.js')}}"></script>

<!--[if lt IE 10]>
            <script src="{{asset('assets/js/placeholder.js')}}"></script>
        <![endif]-->

</body>

</html>
