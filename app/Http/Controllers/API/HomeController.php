<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Home;
use Image;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homes = Home::latest()->paginate(10);
        //echo "<pre>";print_r($homes);die;
        return $homes;
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
            'description' => 'required|string',
            'photo' => 'required|string|min:191',
        ]);

        if($request->isMethod('post')){
            $home = new Home;
            $home->heading=$request['heading'];
            $home->description=$request['description'];
            //check for current photo
            $currentPhoto = $home->photo;
            //Upload Image
            if($request->photo != $currentPhoto){
                $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                \Image::make($request->photo)->save(('images/homes/').$imgUpload);
                //upload to the db using the merge function
                $home->photo = $imgUpload;

                //delete old photo if user updates their homes picture
                $oldPhoto = ('images/homes/').$currentPhoto;
                if (file_exists($oldPhoto)) {
                    @unlink($oldPhoto);
                }

            }
            //echo "<pre>";print_r($product);die;
            $home->save();
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

        $homes = Home::findOrFail($id);
        //validate product information
        $this->validate($request, [
            'heading' => 'required|string|max:191',
            'description' => 'required|string',
        ]);
        //check for current photo
        $currentPhoto = $homes->photo;
        //Upload Image
        if($request->photo != $currentPhoto){
            $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(('images/homes/').$imgUpload);
            //upload to the db using the merge function
            $request->merge(['photo' =>$imgUpload]);

            //delete old photo if homes updates their homepage picture
            $oldPhoto = ('images/homes/').$currentPhoto;
            if (file_exists($oldPhoto)) {
                @unlink($oldPhoto);
            }

        }
        //update homes
         $homes->update($request->all());
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

        $homes = Home::findOrFail($id);
        //delete the homes
        $homes->delete();
        //return ['message' => 'product is Deleted'];
    }
}
