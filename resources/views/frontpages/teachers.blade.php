@extends('layouts.frontLayout.front_design')
@section('content')
<!-- ##### Top Popular Courses Details Area Start ##### -->
<div class="popular-course-details-area wow fadeInUp mt-5" data-wow-delay="300ms">
    <div class="single-top-popular-course d-flex align-items-center flex-wrap">
        <div class="popular-course-content">
            <h5>{{$headteacher->name}}</h5>
            <p>{!! html_entity_decode(nl2br(e($headteacher->description))) !!}</p>
        </div>
        <div class="popular-course-thumb bg-img"style="background-image: url({{ asset('images/teams/'.$headteacher->photo) }}) ;"></div>
    </div>
</div>
<!-- ##### Top Popular Courses Details Area End ##### -->
<!-- ##### Team Area Start ##### -->
<section class="teachers-area section-padding-0-100 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center mx-auto wow fadeInUp" data-wow-delay="300ms">
                    <span>The Best</span>
                    <h3>Meet the Teachers</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Single Teachers -->
            @foreach($teachers as $teacher)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="single-teachers-area text-center mb-100 wow fadeInUp" data-wow-delay="400ms">
                    <!-- Thumbnail -->
                    <div class="teachers-thumbnail">
                        <img src="{{ asset('images/teams/'.$teacher->photo) }}" alt="">
                    </div>
                    <!-- Meta Info -->
                    <div class="teachers-info mt-30">
                        <h5>{{$teacher->name}}</h5>
                        <span>{{$teacher->title}}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- ##### Features Area Start ##### -->
@endsection    