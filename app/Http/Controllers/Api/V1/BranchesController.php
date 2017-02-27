<?php

namespace App\Http\Controllers\Api\V1;

use App\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBranchesRequest;
use App\Http\Requests\UpdateBranchesRequest;
use Yajra\Datatables\Datatables;

class BranchesController extends Controller
{
    public function index()
    {
        return Branch::all();
    }

    public function show($id)
    {
        return Branch::findOrFail($id);
    }

    public function update(UpdateBranchesRequest $request, $id)
    {
        $branch = Branch::findOrFail($id);
        $branch->update($request->all());

        return $branch;
    }

    public function store(StoreBranchesRequest $request)
    {
        $branch = Branch::create($request->all());

        return $branch;
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();
        return '';
    }
}
