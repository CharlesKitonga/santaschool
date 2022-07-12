<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Image;
class UserController extends Controller
{

    /**
     * Create a new controller instance to authenticate users -- api authentication.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
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
            'email' => 'required|string|email|max:191|unique:users',
            'type' => 'required|string|max:191',
            'bio' => 'string|max:191',
            'password' => 'required|string|min:8'
        ]);
        //return $request->all();
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            'photo' => $request['photo'],
            'password' => Hash::make($request['password']),
        ]);
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

    //update user profile account
    public function profile(){
        return auth('api')->user();
    }

    public function updateProfile(Request $request){
        $user = auth('api')->user();
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes'
        ]);

        //check for current photo
        $currentPhoto = $user->photo;
        //Upload Image
        if($request->photo != $currentPhoto){
            $imgUpload = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(('images/profile/').$imgUpload);
            //upload to the db using the merge function
            $request->merge(['photo' =>$imgUpload]);

            //delete old photo if user updates their profile picture
            $oldPhoto = ('images/profile/').$currentPhoto;
            if (file_exists($oldPhoto)) {
                @unlink($oldPhoto);
            }

        }
        //check if password is not empty then update it or leave it if the user does not change the password
        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);

        }
        $user->update($request->all());
        return ['message' => 'updated info'];
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
        $user = User::findOrFail($id);
        //validate user information
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'type' => 'required|string|max:191',
            'bio' => 'string|max:191',
            'password' => 'sometimes|required|min:8'
        ]);
        $user->update($request->all());
        //return ['message' => 'Updating...'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        //delete the user
        $user->delete();
    }
}
