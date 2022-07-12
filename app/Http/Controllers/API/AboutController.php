<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\About;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $abouts = About::latest()->paginate(5);
        //echo "<pre>";print_r($abouts);die;
        return $abouts;
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
            'description' => 'required|string|max:2500',
            'photo' => 'required|string|min:191',
        ]);

        if($request->isMethod('post')){
            $about = new About;
            $about->heading=$request['heading'];
            $about->description=$request['description'];
            //check for current photo
            $currentPhoto = $about->photo;
            //Upload Image
            if($request->photo != $currentPhoto){
                $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                \Image::make($request->photo)->save(('images/homes/').$imgUpload);
                //upload to the db using the merge function
                $about->photo = $imgUpload;

                //delete old photo if user updates their homes picture
                $oldPhoto = public_path('images/homes/').$currentPhoto;
                if (file_exists($oldPhoto)) {
                    @unlink($oldPhoto);
                }

            }
            //echo "<pre>";print_r($product);die;
            $about->save();
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
        $abouts = About::findOrFail($id);
        //validate product information
        $this->validate($request, [
            'heading' => 'required|string|max:191',
            'description' => 'required|string|max:2500',
        ]);
        //check for current photo
        $currentPhoto = $abouts->photo;
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
        //update abouts
         $abouts->update($request->all());
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
        $anouts = About::findOrFail($id);
        //delete the anouts
        $anouts->delete();
        //return ['message' => 'product is Deleted'];
    }
}
