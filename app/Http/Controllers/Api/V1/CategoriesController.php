<?php

namespace App\Http\Controllers\Api\V1;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\Datatables\Datatables;

class CategoriesController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Category::all();
    }

    public function show($id)
    {
        return Category::findOrFail($id);
    }

    public function update(UpdateCategoriesRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $category = Category::findOrFail($id);
        $category->update($request->all());

        return $category;
    }

    public function store(StoreCategoriesRequest $request)
    {
        $request = $this->saveFiles($request);
        $category = Category::create($request->all());

        return $category;
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return '';
    }
}
