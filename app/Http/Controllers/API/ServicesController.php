<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::latest()->paginate(10);
        //echo "<pre>";print_r($services);die;
        return $services;
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
            'service' => 'required|string|max:191',
            'description' => 'required|string|max:191',
            'photo' => 'required|string|min:191',
        ]);

        if($request->isMethod('post')){
            $service = new Service;
            $service->service=$request['service'];
            $service->description=$request['description'];
            //check for current photo
            $currentPhoto = $service->photo;
            //Upload Image
            if($request->photo != $currentPhoto){
                $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                \Image::make($request->photo)->save(('images/services/').$imgUpload);
                //upload to the db using the merge function
                $service->photo = $imgUpload;

                //delete old photo if user updates their ser$services picture
                $oldPhoto = ('images/services/').$currentPhoto;
                if (file_exists($oldPhoto)) {
                    @unlink($oldPhoto);
                }

            }
            //echo "<pre>";print_r($product);die;
            $service->save();
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

        $services = Service::findOrFail($id);
        //validate product information
        $this->validate($request, [
            'service' => 'required|string|max:191',
            'description' => 'required|string|max:191',
        ]);
        //check for current photo
        $currentPhoto = $services->photo;
        //Upload Image
        if($request->photo != $currentPhoto){
            $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(('images/services/').$imgUpload);
            //upload to the db using the merge function
            $request->merge(['photo' =>$imgUpload]);

            //delete old photo if user updates their services picture
            $oldPhoto = ('images/services/').$currentPhoto;
            if (file_exists($oldPhoto)) {
                @unlink($oldPhoto);
            }

        }
        //update ser$services
        $services->update($request->all());
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
        $services = Service::findOrFail($id);
        //delete the homes
        $services->delete();
        //return ['message' => 'product is Deleted'];
    }
}
