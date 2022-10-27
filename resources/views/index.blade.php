@extends('layouts.home')
@section('konten')
<section id="content">

    <div class="content-wrap pt-0">

        <!-- Client Carousel
				============================================= -->
        <div class="section bg-transparent m-0 border-bottom py-5">
            <div class="container">
                <div id="oc-clients" class="owl-carousel image-carousel carousel-widget" data-margin="100"
                    data-loop="true" data-autoplay="5000" data-nav="false" data-pagi="false" data-items-xs="2"
                    data-items-sm="3" data-items-md="4" data-items-lg="5" data-items-xl="6">
                    <div class="oc-item"><a href="https://sirup.lkpp.go.id">
                            <img src="{{URL::asset('depan/852e8-sirup.png')}}" alt=""></a></div>
                    <div class="oc-item"><a href="https://lapor.go.id">
                            <img src="{{URL::asset('depan/LAPORSP4N.jpeg')}}" alt=""></a></div>
                    <div class="oc-item"><a href="https://siga.muaraenimkab.go.id">
                            <img src="{{URL::asset('depan/siga_daerah.png')}}" alt=""></a></div>
                    <div class="oc-item"><a href="https://kla.id">
                            <img src="{{URL::asset('depan/d313b-kla.png')}}" alt=""></a></div>
                    <div class="oc-item"><a href="tel:129">
                            <img src=" {{URL::asset('depan/sapa129.png')}}" alt=""></a></div>
                </div>
            </div>
        </div>

        <!-- Features
				============================================= -->
        <div class="section bg-transparent mt-4 mb-0 pb-0">
            <div class="container">
                <div class="heading-block border-bottom-0 center mx-auto mb-0" style="max-width: 550px">
                    <div class="badge rounded-pill badge-default">Services</div>
                    <h3 class="nott ls0 mb-3">Sambutan Kepala Dinas</h3>
                    <p>Selamat datang di website resmi kami Dinas Pemberdayaan Perempuan dan Perlindungan Anak Kabupaten
                        Muara Enim.
                        Melalui website ini diharapkan masyarakat mendapatkan informasi mengenai pemberdayaan perempuan
                        dan perlindungan anak
                        yang dilakukan oleh DPPPA Kabupaten Muara Enim.</p>
                </div>
                <div class="row justify-content-between align-items-center">

                    <div class="col-lg-4 col-sm-6">

                        <div class="feature-box flex-md-row-reverse text-md-end border-0">
                            <div class="fbox-icon">
                                <a href="#"><img src="{{ URL::asset('guest/demos/seo/images/icons/adword.svg')}}"
                                        alt="Feature Icon" class="bg-transparent rounded-0"></a>
                            </div>
                            <div class="fbox-content">
                                <h3 class="nott ls0">Anugerah KPAI 2022</h3>
                                <p>Pada tahun 2022, Dinas PPPA Kab. Muara Enim memenangkan nominasi Anugerah KPAI 2022.
                                </p>
                            </div>
                        </div>


                        <div class="feature-box flex-md-row-reverse text-md-end border-0 mt-5">
                            <div class="fbox-icon">
                                <a href="#"><img src="{{ URL::asset('guest/demos/seo/images/icons/adword.svg')}}"
                                        alt="Feature Icon" class="bg-transparent rounded-0"></a>
                            </div>
                            <div class="fbox-content">
                                <h3 class="nott ls0">Nominasi 21 Anugerah KPAI</h3>
                                <p>Pada tahun 2021, Dinas PPPA Kab. Muara Enim masuk 21 Kabupaten se-Indonesia dalam
                                    Anugerah
                                    KPAI.</p>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-3 col-7 offset-3 offset-sm-0 d-sm-none d-lg-block center my-5">
                        <img src="{{ URL::asset('depan/kadinpppa.png')}}" alt="iphone" class="rounded parallax"
                            data-bottom-top="transform: translateY(-30px)"
                            data-top-bottom="transform: translateY(30px)"><br>
                        <b>Vivi Mariani, S.Si, M.bmd, Apt</b><br>
                        <b>Kepala Dinas DPPPA</b>
                    </div>

                    <div class="col-lg-4 col-sm-6">

                        <div class="feature-box border-0">
                            <div class="fbox-icon">
                                <a href="#"><img src="{{ URL::asset('guest/demos/seo/images/icons/social.svg')}}"
                                        alt="Feature Icon" class="bg-transparent rounded-0"></a>
                            </div>
                            <div class="fbox-content">
                                <h3 class="nott ls0">Social Media Marketing</h3>
                                <p>IG : dinaspppamuaraenim
                                    <br>
                                    FB : <a href="https://www.facebook.com/Dinaspppamuaraenim">Dinas Pemberdayaan
                                        Perempuan dan Perlindungan Anak</a>
                                </p>
                            </div>
                        </div>

                        <div class="feature-box border-0 mt-5">
                            <div class="fbox-icon">
                                <a href="#"><img src="{{ URL::asset('guest/demos/seo/images/icons/experience.svg')}}"
                                        alt="Feature Icon" class="bg-transparent rounded-0"></a>
                            </div>
                            <div class="fbox-content">
                                <h3 class="nott ls0">Call center</h3>
                                <p>Hubungi SAPA 129</p>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>


        <!-- Blogs
				============================================= -->
        <div class="container py-4">
            <div class="heading-block border-bottom-0 center">
                <h3 class="nott ls0">Berita Terbaru</h3>
            </div>

            <div class="row mt-5 clearfix">

                @foreach ($berita as $p)
                <div class="col-md-4">
                    <article class="entry">
                        <div class="entry-image mb-3">
                            <a href="{{route('berita.guest', $p->slug)}}">><img src="{{URL::asset($p->thumbnail)}}"
                                    alt=""></a>
                        </div>
                        <div class="entry-title">
                            <h3><a href="{{route('berita.guest', $p->slug)}}">{!!
                                    Str::limit($p->judul, 20) !!}</a></h3>
                        </div>
                        <div class="entry-meta">
                            <ul>
                                <li><i class="icon-line2-user"></i><a href="#"> Admin</a></li>
                                <li><i class="icon-calendar-times1"></i><a href="#">
                                        {{$p->created_at->format('d-m-Y')}}</a></li>
                            </ul>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>

        </div>

        <!-- Promo/Contact
				============================================= -->
        <div class="section mt-5 footer-stick promo-section bg-transparent" style="padding: 100px 0; overflow: visible">
            <div class="container">
                <div class="heading-block border-bottom-0 center">
                    <h5 class="text-uppercase ls1 mb-1">Laporkan Tindak Kekerasan</h5>
                    <h2 class="nott ls0">Segera Laporkan Tindak Kekerasan yang anda alami!</h2>
                    <a href="tel:+6282182066124" class="button button-large button-rounded nott ms-0 ls0 mt-4">Hubungi
                        Kami</a>
                </div>
            </div>
        </div>

        <!-- Blogs
				============================================= -->
        <div class="container py-4">
            <div class="heading-block border-bottom-0 center">
                <h3 class="nott ls0">Pengumuman Terbaru</h3>
            </div>

            <div class="row mt-5 clearfix">

                @foreach ($pengumuman as $p)
                <div class="col-md-4">
                    <article class="entry">
                        <div class="entry-image mb-3">
                            <a href="{{route('berita.guest', $p->slug)}}"><img src="{{URL::asset($p->thumbnail)}}"
                                    alt=""></a>
                        </div>
                        <div class="entry-title">
                            <h3><a href="{{route('berita.guest', $p->slug)}}">{!!
                                    Str::limit($p->judul, 20) !!}</a></h3>
                        </div>
                        <div class="entry-meta">
                            <ul>
                                <li><i class="icon-line2-user"></i><a href="#"> Admin</a></li>
                                <li><i class="icon-calendar-times1"></i><a href="#">
                                        {{$p->created_at->format('d-m-Y')}}</a></li>
                            </ul>
                        </div>
                        <div class="entry-content clearfix">
                            {!! Str::limit($p->isi_berita, 20) !!}
                        </div>
                    </article>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section><!-- #content end -->
@endsection
