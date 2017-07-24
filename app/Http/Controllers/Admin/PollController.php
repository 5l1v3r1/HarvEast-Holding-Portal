<?php

namespace App\Http\Controllers\Admin;

use App\Poll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PollController extends Controller
{
    public function store()
    {
    	$this->validate(request(), [
	        'name' => 'required|max:255',
	        'start' => 'required',
	        'end' => 'required',
	        'options.0' => 'required',
            'options.*' => 'required',
    	]);
    	Poll::add();
        return redirect('/admin/polls')->with([
                'message'    => "Опрос добавлен",
                'alert-type' => 'success',
            ]);;
    }

    public function update($id)
    {
        $this->validate(request(), [
            'name' => 'required|max:255',
            'start' => 'required',
            'end' => 'required',
            'options.0' => 'required',
            'options.*' => 'required',
        ]);
        $poll = Poll::find($id);
        $poll->edit();
        return redirect('/admin/polls')->with([
                'message'    => "Опрос обновлен",
                'alert-type' => 'success',
            ]);;
    }
}
