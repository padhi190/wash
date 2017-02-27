<?php

namespace App\Http\Controllers\Api\V1;

use App\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountsRequest;
use App\Http\Requests\UpdateAccountsRequest;
use Yajra\Datatables\Datatables;

class AccountsController extends Controller
{
    public function index()
    {
        return Account::all();
    }

    public function show($id)
    {
        return Account::findOrFail($id);
    }

    public function update(UpdateAccountsRequest $request, $id)
    {
        $account = Account::findOrFail($id);
        $account->update($request->all());

        return $account;
    }

    public function store(StoreAccountsRequest $request)
    {
        $account = Account::create($request->all());

        return $account;
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();
        return '';
    }
}
