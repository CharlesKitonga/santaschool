<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Slider;
use Image;
class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homes = Slider::latest()->paginate(10);
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
            'description' => 'required|string|max:191',
            'photo' => 'required|string|min:191',
        ]);

        if($request->isMethod('post')){
            $slider = new Slider;
            $slider->heading=$request['heading'];
            $slider->description=$request['description'];
            //check for current photo
            $currentPhoto = $slider->photo;
            //Upload Image
            if($request->photo != $currentPhoto){
                $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                \Image::make($request->photo)->save(('images/sliders/').$imgUpload);
                //upload to the db using the merge function
                $slider->photo = $imgUpload;

                //delete old photo if user updates their sliders picture
                $oldPhoto = ('images/sliders/').$currentPhoto;
                if (file_exists($oldPhoto)) {
                    @unlink($oldPhoto);
                }

            }
            //echo "<pre>";print_r($product);die;
            $slider->save();
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

        $homes = Slider::findOrFail($id);
        //validate product information
        $this->validate($request, [
            'heading' => 'required|string|max:191',
            'description' => 'required|string|max:191',
        ]);
        //check for current photo
        $currentPhoto = $homes->photo;
        //Upload Image
        if($request->photo != $currentPhoto){
            $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(('images/sliders/').$imgUpload);
            //upload to the db using the merge function
            $request->merge(['photo' =>$imgUpload]);

            //delete old photo if user updates their Slider picture
            $oldPhoto = ('images/sliders/').$currentPhoto;
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
        $sliders = Slider::findOrFail($id);
        //delete the homes
        $sliders->delete();
        //return ['message' => 'product is Deleted'];
    }
}
