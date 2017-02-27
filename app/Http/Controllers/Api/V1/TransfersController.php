<?php

namespace App\Http\Controllers\Api\V1;

use App\Transfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransfersRequest;
use App\Http\Requests\UpdateTransfersRequest;

class TransfersController extends Controller
{
    public function index()
    {
        return Transfer::all();
    }

    public function show($id)
    {
        return Transfer::findOrFail($id);
    }

    public function update(UpdateTransfersRequest $request, $id)
    {
        $transfer = Transfer::findOrFail($id);
        $transfer->update($request->all());

        return $transfer;
    }

    public function store(StoreTransfersRequest $request)
    {
        $transfer = Transfer::create($request->all());

        return $transfer;
    }

    public function destroy($id)
    {
        $transfer = Transfer::findOrFail($id);
        $transfer->delete();
        return '';
    }
}
