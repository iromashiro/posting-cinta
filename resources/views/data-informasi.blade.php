@extends('layouts.guest')
@section('konten')
<div class="page-content-wrap">

    <div class="container">

        <div class="row">

            <!-- Main content -->
            <main id="main" class="col-md-8">

                @foreach ($berita as $b)

                <div class="content-element5">

                    <div class="blog-type type-2 style-2 list-view">

                        <!-- image post -->
                        <div class="welcome-item">

                            <div class="welcome-inner">

                                <div class="welcome-img">
                                    <img src="{{ URL::asset($b->thumbnail) }}" alt="">
                                </div>

                                <div class="welcome-content">

                                    <svg class="bigHalfCircle" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none">
                                        <path d="M0 100 C40 0 60 0 100 100 Z"></path>
                                    </svg>

                                    <div class="entry">

                                        <!-- - - - - - - - - - - - - - Entry body - - - - - - - - - - - - - - - - -->

                                        <div class="entry-body">

                                            <div class="wrapper">

                                                <h5 class="entry-title"><a href="{{ route('berita.guest', $b->slug) }}">{{ $b->judul }}</a></h5>

                                                <!-- - - - - - - - - - - - - - Entry meta - - - - - - - - - - - - - - - - -->

                                                <div class="entry-meta">

                                                    <div class="entry-byline"><a href="{{ route('berita.guest', $b->slug) }}">Admin</a></div>

                                                </div>

                                                <!-- - - - - - - - - - - - - - Entry meta - - - - - - - - - - - - - - - - -->
                                                {!! substr(strip_tags($b->isi_berita), 0, 150) !!}
                                            </div>

                                        </div>

                                        <!-- - - - - - - - - - - - - - End of Entry body - - - - - - - - - - - - - - - - -->

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                @endforeach
                {{ $berita->links('vendor.pagination.default') }}

            </main>

            <!-- Sidebar-->
            <aside id="sidebar" class="col-md-4">

                <!-- widget News -->
                <div class="widget">

                    <h4 class="widget-title">Berita Terpopuler</h4>

                    <ul class="news-list small-img">

                        @foreach ($berita_side as $bs)
                        <li>

                            <article class="entry">

                                <!-- - - - - - - - - - - - - - Attachment - - - - - - - - - - - - - - - - -->

                                <div class="entry-attachment">

                                    <a class="#" href="{{ route('berita.guest', $bs->slug) }}"><img src="{{ $bs->thumbnail }}" alt=""></a>

                                </div>

                                <!-- - - - - - - - - - - - - - End of Attachment - - - - - - - - - - - - - - - - -->

                                <!-- - - - - - - - - - - - - - Entry body - - - - - - - - - - - - - - - - -->

                                <div class="entry-body">

                                    <!-- - - - - - - - - - - - - - Entry Meta - - - - - - - - - - - - - - - - -->

                                    <div class="entry-meta">

                                        <time class="entry-date" datetime="2016-01-27">{{ $bs->created_at }}</time>

                                    </div>

                                    <!-- - - - - - - - - - - - - - End of Meta - - - - - - - - - - - - - - - - -->

                                    <h5 class="entry-title"><a href="{{ route('berita.guest', $bs->slug) }}">{{ $bs->judul_berita }}</a></h5>

                                    <div class="entry-meta">

                                        <a href="#" class="entry-news">Admin</a>

                                    </div>

                                </div>

                                <!-- - - - - - - - - - - - - - End of Entry body - - - - - - - - - - - - - - - - -->

                            </article>

                        </li>

                        @endforeach


                    </ul>

                </div>
                <!-- /widget -->

                <!-- widget News -->
                <div class="widget">

                    <h4 class="widget-title">Pengumuman</h4>

                    <ul class="news-list small-img">

                        @foreach ($artikel_side as $as)
                        <li>

                            <article class="entry">

                                <!-- - - - - - - - - - - - - - Attachment - - - - - - - - - - - - - - - - -->

                                <div class="entry-attachment">

                                    <a class="#" href="#"><img src="images/100x100_entry1.jpg" alt=""></a>

                                </div>

                                <!-- - - - - - - - - - - - - - End of Attachment - - - - - - - - - - - - - - - - -->

                                <!-- - - - - - - - - - - - - - Entry body - - - - - - - - - - - - - - - - -->

                                <div class="entry-body">

                                    <!-- - - - - - - - - - - - - - Entry Meta - - - - - - - - - - - - - - - - -->

                                    <div class="entry-meta">

                                        <time class="entry-date" datetime="2016-01-27">{{ $as->created_at }}</time>

                                    </div>

                                    <!-- - - - - - - - - - - - - - End of Meta - - - - - - - - - - - - - - - - -->

                                    <h5 class="entry-title"><a href="#">{{ $as->judul_berita }}</a></h5>

                                    <div class="entry-meta">

                                        <a href="#" class="entry-news">Admin</a>

                                    </div>

                                </div>

                                <!-- - - - - - - - - - - - - - End of Entry body - - - - - - - - - - - - - - - - -->

                            </article>

                        </li>

                        @endforeach


                    </ul>

                </div>
                <!-- /widget -->

                <!-- widget Calendar -->
            </aside>

        </div>

    </div>

</div>
@endsection
