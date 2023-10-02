<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        try{
            $tasks =Task::all();
                return response()->json([
                    'data'=>$tasks
                ],200);
        }catch(Exception $error){
            return response()->json([
            'message' => $error->message
            ]  , 501);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

            if($validator -> fails())
                return response()->json($validator->errors());

            try{
                Task::create([
                    'user_id' => $request->user_id,
                    'title' => $request->title,
                    'description' => $request->description
                ]);

                return response()->json([
                    'message' => "Task created successfully!"
                ], 201);
            }catch(Exception $error){
                    return response()->json([
                        'message' => $error->message
                ]  , 501);
            }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request , $id)
    {
        $task = Task::find($id);

        $task->title = $request -> title ;

        $task->description = $request -> description;

        try{
            $task -> save();
                return response()->json([
                    'message'=>"Task Update Successfully!"
                ], 200 );
        }catch(Exception $error){

            return response()->json([
                'message'=>$error->messages
            ], 500 );
        }


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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        try{
            $task -> delete();
            return response()->json([
                'message'=>'Task Deleted Successfully!'
            ],200);
        }catch(Exception $error){
            return response()->json([
                'message'=>$error->messages
            ],500);
        }

    }
}
