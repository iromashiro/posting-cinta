<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--title-->
    <title>Puskesmas Pajar Bulan</title>

    <!--CSS-->
    <link href="{{URL::asset('guest/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('guest/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('guest/css/magnific-popup.css')}}" rel="stylesheet">
    <link href="{{URL::asset('guest/css/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{URL::asset('guest/css/subscribe-better.css')}}" rel="stylesheet">
    <link href="{{URL::asset('guest/css/main.css')}}" rel="stylesheet">
    <link id="preset" rel="stylesheet" type="text/css" href="{{URL::asset('guest/css/presets/preset1.css')}}">
    <link href="{{URL::asset('guest/css/responsive.css')}}" rel="stylesheet">

    <!--Google Fonts-->
    <link href='https://fonts.googleapis.com/css?family=Signika+Negative:400,300,600,700' rel='stylesheet'
        type='text/css'>

    <!--[if lt IE 9]>
	    <script src="{{URL::asset('guest/js/html5shiv.js')}}"></script>
	    <script src="{{URL::asset('guest/js/respond.min.js')}}"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{URL::asset('guest/images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{URL::asset('guest/images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{URL::asset('guest/images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="{{URL::asset('guest/images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed"
        href="{{URL::asset('guest/images/ico/apple-touch-icon-57-precomposed.png')}}">
</head>
<!--/head-->

<body>
    <div id="main-wrapper" class="homepage-two">
        <div id="navigation">
            <div class="navbar" role="banner">

                <div id="menubar">
                    <div class="container">
                        <nav id="mainmenu" class="navbar-right collapse navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li class="sports"><a href="{{ route('index') }}">Home</a></li>
                                <li class="business dropdown"><a href="javascript:void(0);" class="dropdown-toggle"
                                        data-toggle="dropdown">Profil</a>
                                    <ul class="dropdown-menu">
                                        @foreach ($profil as $p)
                                        <li><a href="{{ route('profil', $p->slug) }}">{{ $p->nama_menu }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="politics dropdown"><a href="javascript:void(0);" class="dropdown-toggle"
                                        data-toggle="dropdown">Fasyankes</a>
                                    <ul class="dropdown-menu">
                                        @foreach ($fasyankes as $f)
                                        <li><a href="{{ route('fasyankes', $f->slug) }}">{{ $f->nama_menu }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>

                                <li class="sports"><a href="listing-sports.html">Berita</a></li>
                                <li class="sports"><a href="listing-sports.html">Pengumuman</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!--/#navigation-->
            </div>
            <!--/#navigation-->
        </div>
        <!--/#navigation-->


        <div class="container">
            <div id="breaking-news">
                <span>Pengumuman</span>
                <div class="breaking-news-scroll">
                    <ul>
                        @foreach ($pengumuman as $pp)
                        <li><i class="fa fa-angle-double-right"></i>
                            <a href="?page=post" title="">{!! $pp->judul !!}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!--#breaking-news-->



            <div class="section">
                <div class="col-md-12">
                    <div id="site-content" class="site-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="left-content">
                                    <div class="details-news">
                                        <div class="post">
                                            <div class="post-content">
                                                <div class="entry-meta">
                                                    <ul class="list-inline">
                                                    </ul>
                                                </div>
                                                <h2 class="entry-title text-center">
                                                    {{ $fasyankess->nama_menu }}
                                                </h2>
                                                <div class="entry-content">
                                                    {!! $fasyankess->isi_menu !!}
                                                </div>
                                            </div>
                                        </div>
                                        <!--/post-->
                                    </div>
                                    <!--/.section-->
                                </div>
                                <!--/.left-content-->
                            </div>
                        </div>
                    </div>
                    <!--/#site-content-->
                </div>
                <!--/.col-sm-9 -->
            </div>
            <!--/.section-->

        </div>
        <!--/.container-->

        <footer id="footer">
            <div class="footer-bottom">
                <div class="container text-center">
                    <p><a href="#">Dinas Komunikasi & Informatika Kab. Muara Enim Bidang E-Government </a>&copy; 2021
                    </p>
                </div>
            </div>
        </footer>
    </div>
    <!--/#main-wrapper-->

    <!--/.subscribe-me-->



    <!--/Preset Style Chooser-->
    <div class="style-chooser">
        <div class="style-chooser-inner">
            <a href="#" class="toggler"><i class="fa fa-life-ring fa-spin"></i></a>
            <h4>Presets Color</h4>
            <ul class="preset-list clearfix">
                <li class="preset1 active" data-preset="1"><a href="#" data-color="preset1"></a></li>
                <li class="preset2" data-preset="2"><a href="#" data-color="preset2"></a></li>
                <li class="preset3" data-preset="3"><a href="#" data-color="preset3"></a></li>
                <li class="preset4" data-preset="4"><a href="#" data-color="preset4"></a></li>
                <li class="preset5" data-preset="5"><a href="#" data-color="preset5"></a></li>
                <li class="preset6" data-preset="6"><a href="#" data-color="preset6"></a></li>
            </ul>
        </div>
    </div>
    <!--/End:Preset Style Chooser-->

    <!--/#scripts-->
    <script type="text/javascript" src="{{URL::asset('guest/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('guest/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('guest/js/jquery.magnific-popup.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('guest/js/owl.carousel.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('guest/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('guest/js/jquery.simpleWeather.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('guest/js/jquery.sticky-kit.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('guest/js/jquery.easy-ticker.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('guest/js/main.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('guest/js/switcher.js')}}"></script>

</body>

</html>
