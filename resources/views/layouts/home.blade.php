<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />

    <!-- Stylesheets
	============================================= -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,900&display=swap" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('guest/css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('guest/style.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{ URL::asset('guest/css/dark.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('guest/css/font-icons.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('guest/css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('guest/css/magnific-popup.css')}}" type="text/css" />

    <!-- Bootstrap Switch CSS -->
    <link rel="stylesheet" href="{{ URL::asset('guest/css/components/bs-switches.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{ URL::asset('guest/css/custom.css')}}" type="text/css" />
    <meta name='viewport' content='initial-scale=1, viewport-fit=cover'>

    <!-- Seo Demo Specific Stylesheet -->
    <link rel="stylesheet" href="{{ URL::asset('guest/css/colors.php?color=FE9603')}}" type="text/css" />
    <!-- Theme Color -->
    <link rel="stylesheet" href="{{ URL::asset('guest/demos/seo/css/fonts.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('guest/demos/seo/seo.css')}}" type="text/css" />
    <!-- / -->

    <!-- Document Title
	============================================= -->
    <title>{{ env('NAME_AP') }}</title>
    <link rel="shortcut icon" href="{{ URL::asset('depan/kpppa.png') }}" type="image/x-icon">
</head>

<body class="stretched">

    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper" class="clearfix">

        <!-- Top Bar
		============================================= -->
        <div id="top-bar" class="transparent-topbar">
            <div class="container clearfix">

                <div class="row justify-content-between">

                    <div class="col-12 col-md-auto dark">

                        <!-- Top Social
						============================================= -->
                        <ul id="top-social">

                        </ul><!-- #top-social end -->

                    </div>
                </div>

            </div>
        </div><!-- #top-bar end -->

        <!-- Header
		============================================= -->
        <header id="header" class="transparent-header floating-header header-size-md">
            <div id="header-wrap">
                <div class="container">
                    <div class="header-row">

                        <!-- Logo
						============================================= -->
                        <div id="logo">
                            <a href="index.html" class="standard-logo"
                                data-dark-logo="{{URL::asset('depan/dpppa_me.png')}}"><img
                                    src="{{URL::asset('depan/dpppa_me.png')}}" alt="DPPPA Logo"></a>
                            <a href="index.html" class="retina-logo"
                                data-dark-logo="{{URL::asset('depan/dpppa_me.png')}}"><img
                                    src="{{URL::asset('depan/dpppa_me.png')}}" alt="DPPPA Logo"></a>
                        </div><!-- #logo end -->

                        <div class="header-misc">


                        </div>

                        <div id="primary-menu-trigger">
                            <svg class="svg-trigger" viewBox="0 0 100 100">
                                <path
                                    d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20">
                                </path>
                                <path d="m 30,50 h 40"></path>
                                <path
                                    d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20">
                                </path>
                            </svg>
                        </div>

                        @include('layouts.menu_depan')

                    </div>
                </div>
            </div>
            <div class="header-wrap-clone"></div>
        </header><!-- #header end -->

        <!-- Slider
		============================================= -->
        <section id="slider" class="slider-element slider-parallax min-vh-60 min-vh-md-100 include-header">
            <div class="slider-inner"
                style="background: #FFF url('/depan/header.jpg') center center no-repeat; background-size: cover;">
                <div class="vertical-middle slider-element-fade">
                    <div class="container py-5">
                        <div class="row pt-5">
                            <div class="col-lg-6 col-md-8">
                                <div class="slider-title">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="video-wrap h-100 d-block d-lg-none">
                    <div class="video-overlay" style="background: rgba(255,255,255,0.85);"></div>
                </div>

            </div>
        </section><!-- #slider end -->

        <!-- Content
		============================================= -->
        @yield('konten')
        <!-- Load Facebook SDK for JavaScript -->
        <div id="fb-root"></div>
        <!-- Footer
		============================================= -->
        <footer id="footer" class="border-0 bg-white">


            <!-- Copyrights
			============================================= -->
            <div id="copyrights"
                style="background: url('/guest/seo/images/hero/footer.svg')}}') no-repeat top center; background-size: cover; padding-top: 70px;">
                <div class="container clearfix">

                    <div class="row justify-content-between col-mb-30">
                        <div class="col-12 col-lg-auto text-center text-lg-start">
                            Copyrights &copy; 2022 All Rights Reserved by DPPPA Kab. Muara Enim
                        </div>
                    </div>
                </div>

            </div>
    </div><!-- #copyrights end -->
    </footer><!-- #footer end -->

    </div><!-- #wrapper end -->

    <!-- Go To Top
	============================================= -->
    <div id="gotoTop" class="icon-angle-up"></div>

    <!-- JavaScripts
	============================================= -->
    <script src="{{ URL::asset('guest/js/jquery.js')}}"></script>
    <script src="{{ URL::asset('guest/js/plugins.min.js')}}"></script>

    <!-- Footer Scripts
	============================================= -->
    <script src="{{ URL::asset('guest/js/functions.js')}}"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1
                 &version={graph-api-version}
                 &appId={your-facebook-app-id}
                 &autoLogAppEvents=1" nonce="FOKrbAYI">
    </script>

</body>

</html>
