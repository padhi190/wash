<?php

namespace App\Http\Controllers\Api\V1;

use App\TaskStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskStatusesRequest;
use App\Http\Requests\UpdateTaskStatusesRequest;

class TaskStatusesController extends Controller
{
    public function index()
    {
        return TaskStatus::all();
    }

    public function show($id)
    {
        return TaskStatus::findOrFail($id);
    }

    public function update(UpdateTaskStatusesRequest $request, $id)
    {
        $task_status = TaskStatus::findOrFail($id);
        $task_status->update($request->all());

        return $task_status;
    }

    public function store(StoreTaskStatusesRequest $request)
    {
        $task_status = TaskStatus::create($request->all());

        return $task_status;
    }

    public function destroy($id)
    {
        $task_status = TaskStatus::findOrFail($id);
        $task_status->delete();
        return '';
    }
}
