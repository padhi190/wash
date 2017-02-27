<?php

namespace App\Http\Controllers\Api\V1;

use App\TaskTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskTagsRequest;
use App\Http\Requests\UpdateTaskTagsRequest;

class TaskTagsController extends Controller
{
    public function index()
    {
        return TaskTag::all();
    }

    public function show($id)
    {
        return TaskTag::findOrFail($id);
    }

    public function update(UpdateTaskTagsRequest $request, $id)
    {
        $task_tag = TaskTag::findOrFail($id);
        $task_tag->update($request->all());

        return $task_tag;
    }

    public function store(StoreTaskTagsRequest $request)
    {
        $task_tag = TaskTag::create($request->all());

        return $task_tag;
    }

    public function destroy($id)
    {
        $task_tag = TaskTag::findOrFail($id);
        $task_tag->delete();
        return '';
    }
}
