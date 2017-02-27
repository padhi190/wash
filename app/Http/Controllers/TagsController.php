<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreTagsRequest;
use App\Http\Requests\UpdateTagsRequest;
use Yajra\Datatables\Datatables;

class TagsController extends Controller
{
    /**
     * Display a listing of Tag.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('tag_access')) {
            return abort(401);
        }
        $tags = Tag::all();

        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating new Tag.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('tag_create')) {
            return abort(401);
        }
        return view('tags.create');
    }

    /**
     * Store a newly created Tag in storage.
     *
     * @param  \App\Http\Requests\StoreTagsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagsRequest $request)
    {
        if (! Gate::allows('tag_create')) {
            return abort(401);
        }
        $tag = Tag::create($request->all());

        return redirect()->route('tags.index');
    }


    /**
     * Show the form for editing Tag.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('tag_edit')) {
            return abort(401);
        }
        $tag = Tag::findOrFail($id);

        return view('tags.edit', compact('tag'));
    }

    /**
     * Update Tag in storage.
     *
     * @param  \App\Http\Requests\UpdateTagsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagsRequest $request, $id)
    {
        if (! Gate::allows('tag_edit')) {
            return abort(401);
        }
        $tag = Tag::findOrFail($id);
        $tag->update($request->all());

        return redirect()->route('tags.index');
    }


    /**
     * Display Tag.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('tag_view')) {
            return abort(401);
        }
        $relations = [
            'products' => \App\Product::whereHas('tag',
                    function ($query) use ($id) {
                        $query->where('id', $id);
                    })->get(),
        ];

        $tag = Tag::findOrFail($id);

        return view('tags.show', compact('tag') + $relations);
    }


    /**
     * Remove Tag from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('tag_delete')) {
            return abort(401);
        }
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('tags.index');
    }

    /**
     * Delete all selected Tag at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('tag_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Tag::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
