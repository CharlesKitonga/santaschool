<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\ContactMe;
use Illuminate\Support\Facades\Mail;
use App\Contact;
use Mapper;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Mapper::map(-1.372260, 38.010472);
        //Mapper::informationWindow(-1.372260, 38.010472, 'SantaTilahm School', ['open' => true, 'maxWidth'=> 300, 'autoClose' => true, 'markers' => ['title' => 'SantaTilahm School']]);

        return view('frontpages.contact');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Mapper::map(-1.372260, 38.010472);

       //validate the request & send the email
        $contacts = new Contact($this->validateContact());
        $contacts->save();

        Mail::send(new ContactMe($contacts));

        return view('frontpages.contact')->with('message','Thank You for Your Message we will get in touch..');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function validateContact(){
        return request()->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required',
            'textarea' => 'required'
        ]);
    }
}
