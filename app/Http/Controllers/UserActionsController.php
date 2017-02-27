<?php

namespace App\Http\Controllers;

use App\UserAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreUserActionsRequest;
use App\Http\Requests\UpdateUserActionsRequest;

class UserActionsController extends Controller
{
    /**
     * Display a listing of UserAction.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('user_action_access')) {
            return abort(401);
        }
        $user_actions = UserAction::all();

        return view('user_actions.index', compact('user_actions'));
    }
}
