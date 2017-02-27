<?php
namespace App\Http\Controllers;

use App\Task;

class TaskCalendarsController extends Controller
{
    public function index()
    {
        $events = Task::whereNotNull('due_date')->get();
        return view('task_calendars.index', compact('events'));
    }
}
