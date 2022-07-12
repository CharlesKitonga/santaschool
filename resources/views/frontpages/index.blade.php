@extends('layouts.frontLayout.front_design')
@section('content')
<!-- ##### Hero Area Start ##### -->
<section class="hero-area">
    <div class="hero-slides owl-carousel">
        @foreach($sliders as $slider)
        <!-- Single Hero Slide -->
        <div class="single-hero-slide bg-img" style="background-image: url({{ asset('images/sliders/'.$slider->photo) }}) ;">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <div class="hero-slides-content">
                            <h4 data-animation="fadeInUp" data-delay="100ms">{{$slider->heading}}</h4>
                            <h2 data-animation="fadeInUp" data-delay="400ms">{{$slider->description}}</h2>
                            <a href="{{url('/about-us')}}" class="btn academy-btn" data-animation="fadeInUp" data-delay="700ms">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
<!-- ##### Hero Area End ##### -->

<!-- ##### Top Popular Courses Details Area Start ##### -->
<div class="popular-course-details-area wow fadeInUp" data-wow-delay="300ms">
    <div class="single-top-popular-course d-flex align-items-center flex-wrap">
        <div class="popular-course-content">
            <h5 style ="color: green;">{{$homes->heading}}</h5>
            <p>{!! html_entity_decode(nl2br(e($homes->description))) !!}</p>
            <a href="{{url('/about-us')}}" class="btn academy-btn btn-sm mt-15">See More</a>
        </div>
        <div class="popular-course-thumb bg-img" style="background-image: url({{ asset('images/homes/'.$homes->photo) }}) ;"></div>
    </div>
</div>
<!-- ##### Top Popular Courses Details Area End ##### -->

    <!-- ##### Course Area Start ##### -->
    <div class="academy-courses-area section-padding-100-0">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center mx-auto wow fadeInUp" data-wow-delay="300ms">
                        <span>"Inspired & Committed to Excellence"</span>
                        <h3>School's Core Values</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach($values as $value)
                <!-- Single Course Area -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-course-area d-flex align-items-center mb-100 wow fadeInUp" data-wow-delay="300ms">
                        <div class="course-icon">
                            <i class="icon-id-card"></i>
                        </div>
                        <div class="course-content">
                            <h4>{{$value->heading}}</h4>
                            <p>{!! html_entity_decode(nl2br(e($value->description))) !!}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- ##### Course Area End ##### -->
<!-- ##### CTA Area Start ##### -->
<div class="call-to-action-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cta-content d-flex align-items-center justify-content-between flex-wrap">
                    <h3>Do you want to enrol at our Academy? Get in touch!</h3>
                    <a href="{{url('/contact')}}" class="btn academy-btn">See More</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### CTA Area End ##### -->
@endsection

