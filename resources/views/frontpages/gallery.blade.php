@extends('layouts.frontLayout.front_design')
  @section('content')
    <!-- page-header-start -->
     <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb-area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
        <div class="bradcumbContent">
            <h2>School Gallery</h2>
        </div>
    </div>
    <!-- page-header-close -->
    <!-- treatment start -->
    <div class="top-popular-courses-area mt-50 section-padding-100-70">
        <div class="container">
            <div class="row">
                @foreach($galleries as $gallery)
                <div class="col-12 col-lg-6">
                    <div class="single-top-popular-course d-flex align-items-center flex-wrap mb-30 wow fadeInUp" data-wow-delay="500ms">
                        <div class="popular-course-content">
                             <div class="course-ratings">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            </div>
                            <p>{{$gallery->type}}</p>
                        </div>
                        <div class="popular-course-thumb bg-img" style="background-image: url({{ asset('images/gallery/'.$gallery->photo) }}) ;">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- treatment close -->
@endsection
