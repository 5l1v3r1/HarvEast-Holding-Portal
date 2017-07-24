<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function show(Poll $poll)
    {
    	foreach($poll->options->pluck('name') as $name)
    	{
    		$options[] = ['text' => $name];
    	}
		$text = $poll->name;
    	return compact('options', 'text');
    }
}
