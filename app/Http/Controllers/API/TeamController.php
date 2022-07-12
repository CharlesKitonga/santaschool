<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Team;
use Image;
class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::latest()->paginate(20);
        //echo "<pre>";print_r($teams);die;
        return $teams;
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
            'title' => 'required|string|max:191',
            'photo' => 'required|string|min:191',
        ]);

        if($request->isMethod('post')){
            $team = new Team;
            $team->name=$request['name'];
            $team->title=$request['title'];
            //check for current photo
            $currentPhoto = $team->photo;
            //Upload Image
            if($request->photo != $currentPhoto){
                $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                \Image::make($request->photo)->save(('images/teams/').$imgUpload);
                //upload to the db using the merge function
                $team->photo = $imgUpload;

                //delete old photo if user updates their teams picture
                $oldPhoto = ('images/teams/').$currentPhoto;
                if (file_exists($oldPhoto)) {
                    @unlink($oldPhoto);
                }

            }
            //echo "<pre>";print_r($product);die;
            $team->save();
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
        $teams = Team::findOrFail($id);
        //validate product information
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'title' => 'required|string|max:191',
        ]);
        //check for current photo
        $currentPhoto = $teams->photo;
        //Upload Image
        if($request->photo != $currentPhoto){
            $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(('images/teams/').$imgUpload);
            //upload to the db using the merge function
            $request->merge(['photo' =>$imgUpload]);

            //delete old photo if teams updates their homepage picture
            $oldPhoto = ('images/teams/').$currentPhoto;
            if (file_exists($oldPhoto)) {
                @unlink($oldPhoto);
            }

        }
        //update teams
         $teams->update($request->all());
        //return ['message'=>'updating'
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $teams = Team::findOrFail($id);
        //delete the teams
        $teams->delete();
        //return ['message' => 'member is Deleted'];
    }
}
