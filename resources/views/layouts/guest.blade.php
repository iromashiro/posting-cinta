<!doctype html>
<html lang="en">

<!-- Google Web Fonts
	================================================== -->

<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900" rel="stylesheet">

<!-- Basic Page Needs
	================================================== -->

<title>{{env('NAME_AP')}}</title>

<meta charset="utf-8">
<meta name="author" content="">
<meta name="keywords" content="">
<meta name="description" content="">

<!-- Mobile Specific Metas
	================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Vendor CSS
	============================================ -->

<link rel="stylesheet" href="{{URL::asset('depan/font/demo-files/demo.css')}}">
<link rel="stylesheet" href="{{URL::asset('depan/plugins/revolution/css/settings.css')}}">
<link rel="stylesheet" href="{{URL::asset('depan/plugins/revolution/css/layers.css')}}">
<link rel="stylesheet" href="{{URL::asset('depan/plugins/revolution/css/navigation.css')}}">

<!-- Vendor CSS
	============================================ -->

<link rel="stylesheet" href="{{URL::asset('depan/font/demo-files/demo.css')}}">
<link rel="stylesheet" href="{{URL::asset('depan/plugins/revolution/css/settings.css')}}">
<link rel="stylesheet" href="{{URL::asset('depan/plugins/revolution/css/layers.css')}}">
<link rel="stylesheet" href="{{URL::asset('depan/plugins/revolution/css/navigation.css')}}">

<!-- CSS theme files
	============================================ -->
<link rel="stylesheet" href="{{URL::asset('depan/css/owl.carousel.css')}}">
<link rel="stylesheet" href="{{URL::asset('depan/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{URL::asset('depan/css/fontello.css')}}">
<link rel="stylesheet" href="{{URL::asset('depan/css/style.css')}}">
<link rel="stylesheet" href="{{URL::asset('depan/css/responsive.css')}}">

</head>

<body>


    <!--cookie-->
    <!-- <div class="cookie">
          <div class="container">
            <div class="clearfix">
              <span>Please note this website requires cookies in order to function correctly, they do not store any specific information about you personally.</span>
              <div class="f-right"><a href="#" class="button button-type-3 button-orange">Accept Cookies</a><a href="#" class="button button-type-3 button-grey-light">Read More</a></div>
            </div>
          </div>
        </div>-->

    <!-- - - - - - - - - - - - - - Wrapper - - - - - - - - - - - - - - - - -->

    <div id="wrapper" class="wrapper-container">

        <!-- - - - - - - - - - - - - Mobile Menu - - - - - - - - - - - - - - -->

        <nav id="mobile-advanced" class="mobile-advanced"></nav>

        <!-- - - - - - - - - - - - - - Header - - - - - - - - - - - - - - - - -->

        <header id="header" class="header-2">

            <!-- search-form -->
            <div class="searchform-wrap">
                <div class="vc-child h-inherit relative">

                    <form>
                        <input type="text" name="search" placeholder="Start typing...">
                        <button type="button"></button>
                    </form>

                </div>
                <button class="close-search-form"></button>
            </div>

            <!-- pre-header -->


            <!-- top-header -->
            <div class="top-header">

                <!-- - - - - - - - - - - - / Mobile Menu - - - - - - - - - - - - - -->

                <!--main menu-->

                <div class="menu-holder">

                    <div class="menu-wrap">

                        <div class="container">

                            <div class="table-row">

                                <!-- logo -->

                                <div class="logo-wrap">

                                    <a href="#" class="logo"><img src="{{URL::asset('depan/muara_enim.png')}}" height="50px"></a>

                                </div>

                                <!-- logo -->

                                <div class="call-us">

                                    <ul class="our-info-list">
                                        <li>

                                            <span class="licon-telephone"></span>
                                            <div>
                                                Hubungi Kami:
                                                <a href="wa.me/+6282182066124">0821-8206-6124</a>
                                            </div>

                                        </li>
                                    </ul>

                                    <a href="#" class="btn btn-style-3">Whatsapp</a>

                                </div>

                            </div>

                        </div>

                        <!-- Menu & TopBar -->
                        <div class="nav-item">

                            <div class="container">

                                <!-- - - - - - - - - - - - - - Navigation - - - - - - - - - - - - - - - - -->

                                @include('layouts.menu_depan')

                                <!-- - - - - - - - - - - - - end Navigation - - - - - - - - - - - - - - - -->


                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- bottom-separator -->
            <div class="bottom-separator"></div>

        </header>

        <!-- - - - - - - - - - - - - end Header - - - - - - - - - - - - - - - -->

        <!-- - - - - - - - - - - - - - Content - - - - - - - - - - - - - - - - -->

        <div id="content">

            <!-- - - - - - - - - - - - - - Revolution Slider - - - - - - - - - - - - - - - - -->

            @yield('konten')
            <!--/ page-section -->

        </div>

        <!-- - - - - - - - - - - - - end Content - - - - - - - - - - - - - - - -->

        <!-- - - - - - - - - - - - - - Footer - - - - - - - - - - - - - - - - -->

        <footer id="footer" class="footer-2">

            <!-- Top footer -->
            <div class="top-footer">

                <div class="container">

                    <div class="row">

                        <!-- - - - - - - - - - - - - - Widget - - - - - - - - - - - - - - - - -->
                        <div class="col-md-4 col-xs-12">

                            <div class="widget">

                                <p class="text-center">Jalan Sultan Mahmud Badaruddin II Muara Enim Kecamatan Muara Enim Provinsi Sumsel Kode Pos 31315
                                </p>

                            </div>

                        </div>
                        
                        <div class="col-md-4 col-xs-12">
                            </div>
                        <!-- - - - - - - - - - - - - - Widget - - - - - - - - - - - - - - - - -->
<div class="col-md-4 col-xs-12">
						
						<div class="widget">


			                <ul class="social-icons style-2">

				                <li class="fb-icon"><a href="https://www.facebook.com/dpppamuaraenim"><i class="icon-facebook"></i></a></li>
				                <li class="insta-icon"><a href="https://www.instagram.com/dpppamuaraenim/"><i class="icon-instagram-4"></i></a></li>

				            </ul>

				            <p class="copyright">Copyright <span>Dinas PPA Kab. Muara Enim</span> © 2021. <br> All Rights Reserved</p>

			            </div>

					</div>
                        <!-- - - - - - - - - - - - - - Widget - - - - - - - - - - - - - - - - -->

                    </div>

                </div>

            </div>

        </footer>

        <div id="footer-scroll"></div>

        <!-- - - - - - - - - - - - - end Footer - - - - - - - - - - - - - - - -->

    </div>

    <!-- - - - - - - - - - - - end Wrapper - - - - - - - - - - - - - - -->

    <!-- JS Libs & Plugins
  ============================================ -->
    <script src="{{URL::asset('depan/js/libs/jquery.modernizr.js')}}"></script>
    <script src="{{URL::asset('depan/js/libs/jquery-2.2.4.min.js')}}"></script>
    <script src="{{URL::asset('depan/js/libs/jquery-ui.min.js')}}"></script>
    <script src="{{URL::asset('depan/js/libs/retina.min.js')}}"></script>
    <script src="{{URL::asset('depan/plugins/jquery.scrollTo.min.js')}}"></script>
    <script src="{{URL::asset('depan/plugins/jquery.localScroll.min.js')}}"></script>
    <script src="{{URL::asset('depan/plugins/jquery.countdown.plugin.min.js')}}"></script>
    <script src="{{URL::asset('depan/plugins/jquery.countdown.min.js')}}"></script>
    <script src="{{URL::asset('depan/plugins/owl.carousel.min.js')}}"></script>
    <script src="{{URL::asset('depan/plugins/revolution/js/jquery.themepunch.tools.min.js')}}"></script>
    <script src="{{URL::asset('depan/plugins/revolution/js/jquery.themepunch.revolution.min.js')}}"></script>
    <script type="text/javascript"
        src="{{URL::asset('depan/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js')}}">
    </script>
    <script type="text/javascript"
        src="{{URL::asset('depan/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js')}}">
    </script>
    <script type="text/javascript"
        src="{{URL::asset('depan/plugins/revolution/js/extensions/revolution.extension.navigation.min.js')}}">
    </script>
    <!-- JS theme files
  ============================================ -->
    <script src="{{URL::asset('depan/js/plugins.js')}}"></script>
    <script src="{{URL::asset('depan/js/script.js')}}"></script>
    @yield('js')

</body>

</html>
