<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use Image;
class ClientsController extends Controller
{    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       $clients = Client::latest()->paginate(10);
       //echo "<pre>";print_r($clients);die;
       return $clients;
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
           'name' => 'required|string|max:191',
           'photo' => 'required|string|min:191',
       ]);

       if($request->isMethod('post')){
           $client = new Client;
           $client->name=$request['name'];
           //check for current photo
           $currentPhoto = $client->photo;
           //Upload Image
           if($request->photo != $currentPhoto){
               $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
               \Image::make($request->photo)->save(('images/clients/').$imgUpload);
               //upload to the db using the merge function
               $client->photo = $imgUpload;

               //delete old photo if user updates their clients picture
               $oldPhoto = public_path('images/clients/').$currentPhoto;
               if (file_exists($oldPhoto)) {
                   @unlink($oldPhoto);
               }

           }
           //echo "<pre>";print_r($product);die;
           $client->save();
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

       $client = Client::findOrFail($id);
       //validate product information
       $this->validate($request, [
           'name' => 'required|string|max:191',
       ]);
       //check for current photo
       $currentPhoto = $client->photo;
       //Upload Image
       if($request->photo != $currentPhoto){
           $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
           \Image::make($request->photo)->save(('images/clients/').$imgUpload);
           //upload to the db using the merge function
           $request->merge(['photo' =>$imgUpload]);

           //delete old photo if user updates their Slider picture
           $oldPhoto = public_path('images/clients/').$currentPhoto;
           if (file_exists($oldPhoto)) {
               @unlink($oldPhoto);
           }

       }
       //update client
       $client->update($request->all());
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

       $clients = Client::findOrFail($id);
       //delete the homes
       $clients->delete();
       //return ['message' => 'product is Deleted'];
   }
}
