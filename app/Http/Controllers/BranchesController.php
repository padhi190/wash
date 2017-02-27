<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreBranchesRequest;
use App\Http\Requests\UpdateBranchesRequest;
use Yajra\Datatables\Datatables;

class BranchesController extends Controller
{
    /**
     * Display a listing of Branch.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('branch_access')) {
            return abort(401);
        }
        $branches = Branch::all();

        return view('branches.index', compact('branches'));
    }

    /**
     * Show the form for creating new Branch.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('branch_create')) {
            return abort(401);
        }
        return view('branches.create');
    }

    /**
     * Store a newly created Branch in storage.
     *
     * @param  \App\Http\Requests\StoreBranchesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchesRequest $request)
    {
        if (! Gate::allows('branch_create')) {
            return abort(401);
        }
        $branch = Branch::create($request->all());

        return redirect()->route('branches.index');
    }


    /**
     * Show the form for editing Branch.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('branch_edit')) {
            return abort(401);
        }
        $branch = Branch::findOrFail($id);

        return view('branches.edit', compact('branch'));
    }

    /**
     * Update Branch in storage.
     *
     * @param  \App\Http\Requests\UpdateBranchesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBranchesRequest $request, $id)
    {
        if (! Gate::allows('branch_edit')) {
            return abort(401);
        }
        $branch = Branch::findOrFail($id);
        $branch->update($request->all());

        return redirect()->route('branches.index');
    }


    /**
     * Display Branch.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('branch_view')) {
            return abort(401);
        }
        $relations = [
            'customers' => \App\Customer::where('branch_id', $id)->get(),
            'absensis' => \App\Absensi::where('branch_id', $id)->get(),
            'incomes' => \App\Income::where('branch_id', $id)->get(),
            'expenses' => \App\Expense::where('branch_id', $id)->get(),
            'transfers' => \App\Transfer::where('branch_id', $id)->get(),
            'tasks' => \App\Task::where('branch_id', $id)->get(),
            'employees' => \App\Employee::where('branch_id', $id)->get(),
            'users' => \App\User::where('branch_id', $id)->get(),
        ];

        $branch = Branch::findOrFail($id);

        return view('branches.show', compact('branch') + $relations);
    }


    /**
     * Remove Branch from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('branch_delete')) {
            return abort(401);
        }
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return redirect()->route('branches.index');
    }

    /**
     * Delete all selected Branch at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('branch_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Branch::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
