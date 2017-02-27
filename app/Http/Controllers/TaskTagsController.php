<?php

namespace App\Http\Controllers;

use App\TaskTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreTaskTagsRequest;
use App\Http\Requests\UpdateTaskTagsRequest;

class TaskTagsController extends Controller
{
    /**
     * Display a listing of TaskTag.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('task_tag_access')) {
            return abort(401);
        }
        $task_tags = TaskTag::all();

        return view('task_tags.index', compact('task_tags'));
    }

    /**
     * Show the form for creating new TaskTag.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('task_tag_create')) {
            return abort(401);
        }
        return view('task_tags.create');
    }

    /**
     * Store a newly created TaskTag in storage.
     *
     * @param  \App\Http\Requests\StoreTaskTagsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskTagsRequest $request)
    {
        if (! Gate::allows('task_tag_create')) {
            return abort(401);
        }
        $task_tag = TaskTag::create($request->all());

        return redirect()->route('task_tags.index');
    }


    /**
     * Show the form for editing TaskTag.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('task_tag_edit')) {
            return abort(401);
        }
        $task_tag = TaskTag::findOrFail($id);

        return view('task_tags.edit', compact('task_tag'));
    }

    /**
     * Update TaskTag in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskTagsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskTagsRequest $request, $id)
    {
        if (! Gate::allows('task_tag_edit')) {
            return abort(401);
        }
        $task_tag = TaskTag::findOrFail($id);
        $task_tag->update($request->all());

        return redirect()->route('task_tags.index');
    }


    /**
     * Display TaskTag.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('task_tag_view')) {
            return abort(401);
        }
        $relations = [
            'tasks' => \App\Task::whereHas('tag',
                    function ($query) use ($id) {
                        $query->where('id', $id);
                    })->get(),
        ];

        $task_tag = TaskTag::findOrFail($id);

        return view('task_tags.show', compact('task_tag') + $relations);
    }


    /**
     * Remove TaskTag from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('task_tag_delete')) {
            return abort(401);
        }
        $task_tag = TaskTag::findOrFail($id);
        $task_tag->delete();

        return redirect()->route('task_tags.index');
    }

    /**
     * Delete all selected TaskTag at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('task_tag_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = TaskTag::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
