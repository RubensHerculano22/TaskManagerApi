<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    private $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $task = auth('api')->user()->task()->with('user')->with('category');

        return response()->json($task->paginate('10'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $data = $request->all();

        try {
            $data['user_id'] = auth('api')->user()->id;
            $task = $this->task->create($data); //Mass Asignment

            return response()->json([
                'data' => [
                    'msg' => 'Tarefa cadastrado com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json(['error' => $message->getMessage()], 401);
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
        try {
            $task = auth('api')->user()->task()->with('user')->with('category')->findOrFail($id);

            return response()->json([
                'data' => $task
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json(['error' => $message->getMessage()], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        $data = $request->all();

        try {

            $task = auth('api')->user()->task()->findOrFail($id);
            $task->update($data); //Mass Asignment

            return response()->json([
                'data' => [
                    'msg' => 'Tarefa atualizado com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json(['error' => $message->getMessage()], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $task = auth('api')->user()->task()->findOrFail($id);
            $task->delete(); //Mass Asignment

            return response()->json([
                'data' => [
                    'msg' => 'Tarefa removido com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json(['error' => $message->getMessage()], 401);
        }
    }
}
