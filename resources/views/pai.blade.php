@extends('layouts.home')
@section('konten')
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row gutter-40 col-mb-80">
                <!-- Post Content
						============================================= -->
                <div class="postcontent col-lg-9">

                    <!-- Posts
							============================================= -->
                    <div id="posts" class="post-grid row grid-container gutter-40 clearfix" data-layout="fitRows">


                        @foreach ($berita as $b)
                        <div class="entry col-md-4 col-sm-6 col-12">
                            <div class="grid-inner">
                                <div class="entry-title">
                                    <h2><a href="{{ route('pai.guest', $b->slug) }}">{{ $b->nama_menu }}</a></h2>
                                </div>
                                <div class="entry-meta">
                                    <ul>
                                        <li><i class="icon-calendar3"></i> {{$b->created_at->format('d,m,Y')}}</li>
                                        <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div><!-- #posts end -->

                    <div class="clear mt-5"></div>

                    <!-- Pagination
							============================================= -->
                    <div class="d-flex justify-content-between mt-5">
                        <a href="#" class="btn btn-outline-secondary">&larr; Older</a>
                        <a href="#" class="btn btn-outline-dark">Newer &rarr;</a>
                    </div>
                    <!-- .pager end -->

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

                                            @foreach ($berita_side as $bs)
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
