<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Gallery;
use Image;
class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gallery = Gallery::latest()->paginate(20);
        //echo "<pre>";print_r($gallery);die;
        return $gallery;
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
            'type' => 'required|string|max:191',
            'photo' => 'required|string|min:191',
        ]);

        if($request->isMethod('post')){
            $galleries = new Gallery;
            $galleries->type=$request['type'];
            //check for current photo
            $currentPhoto = $galleries->photo;
            //Upload Image
            if($request->photo != $currentPhoto){
                $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                \Image::make($request->photo)->save(('images/gallery/').$imgUpload);
                //upload to the db using the merge function
                $galleries->photo = $imgUpload;

                //delete old photo if user updates their gallery picture
                $oldPhoto = public_path('images/gallery/').$currentPhoto;
                if (file_exists($oldPhoto)) {
                    @unlink($oldPhoto);
                }

            }
            //echo "<pre>";print_r($product);die;
            $galleries->save();
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
        $galleries = Gallery::findOrFail($id);
        //validate product information
        $this->validate($request, [
            'type' => 'required|string|max:191',
        ]);
        //check for current photo
        $currentPhoto = $galleries->photo;
        //Upload Image
        if($request->photo != $currentPhoto){
            $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(('images/gallery/').$imgUpload);
            //upload to the db using the merge function
            $request->merge(['photo' =>$imgUpload]);

            //delete old photo if user updates their Slider picture
            $oldPhoto = ('images/gallery/').$currentPhoto;
            if (file_exists($oldPhoto)) {
                @unlink($oldPhoto);
            }

        }
        //update galleries$galleries
        $galleries->update($request->all());
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

        $galleries = Gallery::findOrFail($id);
        //delete the homes
        $galleries->delete();
        //return ['message' => 'product is Deleted'];
    }
}
