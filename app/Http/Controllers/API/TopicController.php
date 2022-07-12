<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Topic;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::latest()->paginate(10);
        //echo "<pre>";print_r($topics);die;
        return $topics;
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
            'topic' => 'required|string|max:191',
            'description' => 'required|string|max:191',
        ]);

        if($request->isMethod('post')){
            $topic = new Topic;
            $topic->topic=$request['topic'];
            $topic->description=$request['description'];
            //echo "<pre>";print_r($product);die;
            $topic->save();
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

        $topics = Topic::findOrFail($id);
        //validate product information
        $this->validate($request, [
            'topic' => 'required|string|max:191',
            'description' => 'required|string|max:191',
        ]);
        //update ser$topics
            $topics->update($request->all());
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
        $topics = Topic::findOrFail($id);
        //delete the homes
        $topics->delete();
        //return ['message' => 'product is Deleted'];
    }
}
