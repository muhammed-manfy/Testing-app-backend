<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Task;
use App\Models\User;
class TasksController extends Controller
{

  
    public function createTask(Request $request){

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


    public function getUserTasks($user_id)

    {
        try{

            $userTasks = Task::all()->where('user_id',$user_id);

                return response()->json([
                    'data'=>$userTasks,
                ], 200);

        }catch(Exception $error){
            return response()->json([
                'message'=> $error->message
            ]);
        }

    }


    public function updateTask(Request $request , $id)
    {
        $task = Task::find($id);

        $task->title = $request -> title ;

        $task->description = $request -> description;

        try{
            $task -> save();
                return response()->json([
                    'message'=>"Task Updated Successfully!"
                ], 200 );
        }catch(Exception $error){

            return response()->json([
                'message'=>$error->messages
            ], 500 );
        }


    }

    public function getTask($id)
    {
        try{

            $task = Task::find($id);
            return response()->json([
                'data'=> $task
            ] , 200);

        }catch(Exception $error){
            return response()->json([
                'message'=> $error->message
            ] , 500);
        }
    }


    public function deleteTask($id)
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
