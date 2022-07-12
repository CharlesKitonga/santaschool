@extends('layouts.frontLayout.front_design')
@section('content')
    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb-area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
        <div class="bradcumbContent">
            <h2>About Us</h2>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### About Us Area Start ##### -->
    <section class="about-us-area mt-50 section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center mx-auto wow fadeInUp" data-wow-delay="300ms">
                        <span style ="color: green;"><strong>{{$abouts->heading}}</strong></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                    <p>{!! html_entity_decode(nl2br(e($abouts->description))) !!}</p>
                </div>
                <div class="col-12 col-md-6 wow fadeInUp" data-wow-delay="500ms">
                    <img src="{{asset('img/bg-img/pc-2.jpg')}}" alt="" srcset="">
                </div>
            </div>
        </div>
    </section>
    <!-- ##### About Us Area End ##### -->

@endsection
