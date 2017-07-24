<?php

namespace App\Http\Controllers;

use App\Bid;
use App\BidCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function index()
    {
    	return view('bid.index');
    }


    /**
     * Save and send to email users bid
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function place(Bid $bid)
    {
        $fields = json_decode($bid->fields, true);
        $validate = [];
        foreach ($fields as $id => $field) {
            if($field['required'])
            {
                $validate[$id] = 'required';
            }
        }
        $this->validate(request(), $validate);
    	$user = Auth::user();       
    	$user->placeBid($fields, $bid);
    	return redirect('/bids')->with('status', 'Bid Sent!');
    }

    public function show(Bid $bid)
    {
        if(request()->ajax())
            return $bid->fields;
    	return view('bid.show', compact('bid'));
    }
}
