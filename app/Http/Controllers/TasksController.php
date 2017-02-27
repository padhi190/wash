<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreTasksRequest;
use App\Http\Requests\UpdateTasksRequest;

class TasksController extends Controller
{
    /**
     * Display a listing of Task.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('task_access')) {
            return abort(401);
        }
        $tasks = Task::all();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating new Task.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('task_create')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'kendaraans' => \App\Vehicle::get()->pluck('license_plate', 'id')->prepend('Please select', ''),
            'statuses' => \App\TaskStatus::get()->pluck('name', 'id')->prepend('Please select', ''),
            'tags' => \App\TaskTag::get()->pluck('name', 'id'),
        ];

        return view('tasks.create', $relations);
    }

    /**
     * Store a newly created Task in storage.
     *
     * @param  \App\Http\Requests\StoreTasksRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTasksRequest $request)
    {
        if (! Gate::allows('task_create')) {
            return abort(401);
        }
        $task = Task::create($request->all());
        $task->tag()->sync(array_filter((array)$request->input('tag')));

        return redirect()->route('tasks.index');
    }


    /**
     * Show the form for editing Task.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('task_edit')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'kendaraans' => \App\Vehicle::get()->pluck('license_plate', 'id')->prepend('Please select', ''),
            'statuses' => \App\TaskStatus::get()->pluck('name', 'id')->prepend('Please select', ''),
            'tags' => \App\TaskTag::get()->pluck('name', 'id'),
        ];

        $task = Task::findOrFail($id);

        return view('tasks.edit', compact('task') + $relations);
    }

    /**
     * Update Task in storage.
     *
     * @param  \App\Http\Requests\UpdateTasksRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTasksRequest $request, $id)
    {
        if (! Gate::allows('task_edit')) {
            return abort(401);
        }
        $task = Task::findOrFail($id);
        $task->update($request->all());
        $task->tag()->sync(array_filter((array)$request->input('tag')));

        return redirect()->route('tasks.index');
    }


    /**
     * Display Task.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('task_view')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'kendaraans' => \App\Vehicle::get()->pluck('license_plate', 'id')->prepend('Please select', ''),
            'statuses' => \App\TaskStatus::get()->pluck('name', 'id')->prepend('Please select', ''),
            'tags' => \App\TaskTag::get()->pluck('name', 'id'),
        ];

        $task = Task::findOrFail($id);

        return view('tasks.show', compact('task') + $relations);
    }


    /**
     * Remove Task from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('task_delete')) {
            return abort(401);
        }
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index');
    }

    /**
     * Delete all selected Task at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('task_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Task::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
