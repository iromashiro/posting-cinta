@extends('layouts.guest')
@section('konten')
<div id="content">

    <!-- - - - - - - - - - - - - - Breadcrumbs - - - - - - - - - - - - - - - - -->

    <div class="breadcrumbs-wrap">

        <div class="container">

            <h1 class="page-title">Grid Gallery</h1>
            <ul class="breadcrumbs">

                <li><a href="index.html">Home</a></li>
                <li>Grid Gallery</li>

            </ul>

        </div>

    </div>

    <!-- - - - - - - - - - - - - end Breadcrumbs - - - - - - - - - - - - - - - -->

    <!-- page-section -->

    <div class="page-section">

        <div class="container">

            <div class="isotope three-collumn clearfix portfolio-holder"
                data-isotope-options='{"itemSelector" : ".item","layoutMode" : "masonry","transitionDuration":"0.7s","masonry" : {"columnWidth":".item"}}'>


                @foreach ($galeri as $g)
                <div class="item category_2">

                    <!-- - - - - - - - - - - - - - Project - - - - - - - - - - - - - - - - -->

                    <div class="project">

                        <!-- - - - - - - - - - - - - - Project Image - - - - - - - - - - - - - - - - -->

                        <div class="project-image">

                            <img src="{{Storage::URL($g->path)}}" alt="">
                            <a href="{{Storage::URL($g->path)}}" class="project-link project-action fancybox"
                                title="Title 1" rel="category"></a>

                        </div>

                        <!-- - - - - - - - - - - - - - End of Project Image - - - - - - - - - - - - - - - - -->

                    </div>

                    <!-- - - - - - - - - - - - - - End of Project - - - - - - - - - - - - - - - - -->

                </div>
                @endforeach
            </div>

            <ul class="pagination">
                <li>
                    <a href="#" class="prev-page"></a>
                </li>
                <li>
                    <a href="#">1</a>
                </li>
                <li>
                    <a href="#">2</a>
                </li>
                <li>
                    <a href="#">3</a>
                </li>
                <li>
                    <a href="#" class="next-page"></a>
                </li>
            </ul>

        </div>

    </div>

</div>
@endsection
@section('js')


<script src="{{URL::asset('depan/js/libs/retina.min.js')}}"></script>
<script src="{{URL::asset('depan/plugins/isotope.pkgd.min.js')}}"></script>
@endsection
