@extends('layouts.home')
@section('konten')
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row gutter-40 col-mb-80">
                <!-- Post Content
						============================================= -->
                <div class="postcontent col-lg-9 order-lg-last">

                    <div class="single-post mb-0">

                        <!-- Single Post
								============================================= -->
                        <div class="entry clearfix">

                            <!-- Entry Title
									============================================= -->
                            <div class="entry-title">
                                <h2>{{$berita->nama_menu}}</h2>
                            </div><!-- .entry-title end -->

                            <!-- Entry Meta
									============================================= -->
                            <div class="entry-meta">
                                <ul>
                                    <li><i class="icon-calendar3"></i> {{$berita->created_at->format('d-m-Y')}}</li>
                                    <li><a href="#"><i class="icon-user"></i> admin</a></li>
                                    <li><a href="#"><i class="icon-camera-retro"></i></a></li>

                                </ul>
                            </div><!-- .entry-meta end -->

                            <!-- Entry Content
									============================================= -->
                            <div class="entry-content mt-0">

                                <embed src="{{ Storage::url($berita->path) }}" height="1280px" width="700px" />

                            </div>
                        </div><!-- .entry end -->



                    </div>

                </div><!-- .postcontent end -->

                <!-- Sidebar
						============================================= -->
                <div class="sidebar col-lg-3">
                    <div class="sidebar-widgets-wrap">

                        <div class="widget widget-twitter-feed clearfix">

                            <h4>Twitter Feed</h4>
                            <ul class="iconlist twitter-feed" data-username="envato" data-count="2">
                                <li></li>
                            </ul>

                            <a href="#" class="btn btn-secondary btn-sm float-end">Follow Us on Twitter</a>

                        </div>

                        <div class="widget clearfix">

                            <div class="tabs mb-0 clearfix" id="sidebar-tabs">

                                <ul class="tab-nav clearfix">
                                    <li><a href="#tabs-1">Popular</a></li>
                                    <li><a href="#tabs-2">Recent</a></li>
                                    <li><a href="#tabs-3"><i class="icon-comments-alt me-0"></i></a></li>
                                </ul>

                                <div class="tab-container">

                                    <div class="tab-content clearfix" id="tabs-1">
                                        <div class="posts-sm row col-mb-30" id="popular-post-list-sidebar">

                                            @foreach ($pn as $bs)
                                            <div class="entry col-12">
                                                <div class="grid-inner row g-0">
                                                    <div class="col-auto">
                                                        <div class="entry-image">
                                                            <a href="{{ route('berita.guest', $bs->slug) }}"><img
                                                                    class="rounded-circle"
                                                                    src="{{ URL::asset($bs->thumbnail) }}"
                                                                    alt="Image"></a>
                                                        </div>
                                                    </div>
                                                    <div class="col ps-3">
                                                        <div class="entry-title">
                                                            <h4><a
                                                                    href="{{ route('berita.guest', $bs->slug) }}">{{ $bs->judul }}</a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach


                                        </div>
                                    </div>
                                    <div class="tab-content clearfix" id="tabs-2">
                                        <div class="posts-sm row col-mb-30" id="recent-post-list-sidebar">
                                            <div class="entry col-12">
                                                <div class="grid-inner row g-0">
                                                    <div class="col-auto">
                                                        <div class="entry-image">
                                                            <a href="#"><img class="rounded-circle"
                                                                    src="images/magazine/small/1.jpg" alt="Image"></a>
                                                        </div>
                                                    </div>
                                                    <div class="col ps-3">
                                                        <div class="entry-title">
                                                            <h4><a href="#">Lorem ipsum dolor sit amet, consectetur</a>
                                                            </h4>
                                                        </div>
                                                        <div class="entry-meta">
                                                            <ul>
                                                                <li>10th July 2021</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div><!-- .sidebar end -->
            </div>

        </div>
    </div>
</section><!-- #content end -->
@endsection
