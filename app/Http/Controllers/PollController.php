<?php

namespace App\Http\Controllers;

use App\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
	public function vote()
	{
		Poll::vote((int) request()->option);
		return redirect('/');
	}
}
