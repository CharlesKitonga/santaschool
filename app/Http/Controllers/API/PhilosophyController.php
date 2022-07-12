<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Philosophy;

class PhilosophyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = Philosophy::latest()->paginate(10);
        //echo "<pre>";print_r($details);die;
        return $details;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'heading' => 'required|string|max:191',
            'description' => 'required|string|max:1000',
        ]);

        if($request->isMethod('post')){
            $details = new Philosophy;
            $details->heading=$request['heading'];
            $details->description=$request['description'];
            //check for current photo
            $currentPhoto = $details->photo;
            //Upload Image
            if($request->photo != $currentPhoto){
                $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                \Image::make($request->photo)->save(('images/homes/').$imgUpload);
                //upload to the db using the merge function
                $details->photo = $imgUpload;

                //delete old photo if user updates their homes picture
                $oldPhoto = ('images/homes/').$currentPhoto;
                if (file_exists($oldPhoto)) {
                    @unlink($oldPhoto);
                }

            }
            //echo "<pre>";print_r($product);die;
            $details->save();
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $details = Philosophy::findOrFail($id);
        //validate product information
        $this->validate($request, [
            'heading' => 'required|string|max:191',
            'description' => 'required|string|max:1000',
        ]);
        //check for current photo
        $currentPhoto = $details->photo;
        //Upload Image
        if($request->photo != $currentPhoto){
            $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(('images/homes/').$imgUpload);
            //upload to the db using the merge function
            $request->merge(['photo' =>$imgUpload]);

            //delete old photo if user updates their About picture
            $oldPhoto = ('images/homes/').$currentPhoto;
            if (file_exists($oldPhoto)) {
                @unlink($oldPhoto);
            }

        }
        //update details
         $details->update($request->all());
        //return ['message'=>'updating'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $details = Philosophy::findOrFail($id);
        //delete the details
        $details->delete();
        //return ['message' => 'product is Deleted'];
    }
}
