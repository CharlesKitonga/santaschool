<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\About;
use App\Contact;
use App\Gallery;
use App\Home;
use Mapper;
use App\Philosophy;
use App\Slider;
use App\TeamLeader;
use App\Team;
class PagesController extends Controller
{
    public function Index(){
        //fetch slider info
        $sliders = Slider::get();
        $sliders = json_decode(json_encode($sliders));
        //fetch homepage details
        $homes = Home::first();
        $homes = json_decode(json_encode($homes));
        //fetch school values
        $values = Philosophy::get();
        $values = json_decode(json_encode($values));

        return view('frontpages.index')->with(compact('sliders','homes','values'));
    }
    public function About(){
        $abouts = About::first();
    	return view('frontpages.about-us')->with(compact('abouts'));
    }
    public function Teachers(){
        //fetch head teacher's comments
        $headteacher = TeamLeader::first();
        //fetch the rest of the teacher's details
        $teachers = Team::get();
        $teachers = json_decode(json_encode($teachers));
    	return view('frontpages.teachers')->with(compact('headteacher','teachers'));
    }
    public function Admissions(){
    	return view('frontpages.admissions');
    }
    public function Gallery(){
        //fetch gallery photos
        $galleries = Gallery::latest('created_at')->limit(20)->get();
        $galleries = json_decode(json_encode($galleries));

        return view('frontpages.gallery', compact('galleries'));
    }
    public function News(){
    	return view('frontpages.news-single');
    }
        public function Contact(Request $request){
            Mapper::map(-1.372260, 38.010472);

            if ($request->isMethod('post')) {
                $data = $request->all();
                //echo("<pre>");print_r($data);die;

                $contacts = new Contact;
                $contacts->name = $data['name'];
                $contacts->email = $data['email'];
                $contacts->subject = $data['subject'];
                $contacts->textarea = $data['textarea'];
                $contacts->save();

            }
        return view('frontpages.contact')->with('success','Thank You for Your Message we will get in touch..');
    }
}
