<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
	protected $fillable = ['name', 'start', 'end'];
	protected $dates = [
		'start',
		'end'
    ];

    public static function add()
    {
        $request = self::prepareRequest();
        $poll = Poll::create($request);

    	foreach (request()->options as $option) 
    	{
    		Option::create(['name' => $option, 'poll_id' => $poll->id]);
    	}
    }

    public function edit()
    {
        $request = self::prepareRequest();
        $this->update($request);
        
        Option::where('poll_id', $this->id)->delete();
        foreach (request()->options as $option) 
        {
            Option::create(['name' => $option, 'poll_id' => $this->id]);
        }         
    }

    public function changedOptions()
    {
        return count(request()->options) !== count($this->options->whereIn('name', request()->options)->all());
    }

    public static function prepareRequest()
    {
        $request = request()->except('options', '_token');
        $request['start'] = Carbon::parse($request['start']);
        $request['end'] = Carbon::parse($request['end']);
        return $request;
    }

    public function options()
    {
    	return $this->hasMany(Option::class);
    }

    public static function current()
    {
    	return self::where('start', '<=', Carbon::now())
                    ->where('end', '>=', Carbon::now())
    				->orderBy('start', 'desc')
    				->first();
    }

    public function results()
    {
        return $this->options->pluck('votes', 'name');
    }

    public static function vote($option_id)
    {
    	$option = Option::where('id', $option_id)->first();
    	$option->votes += 1;
    	$option->save();
    	Vote::create(['user_id' => Auth::id(), 'option_id' => $option_id]);
    }

    public function isComplete()
    {
        return $this->end <= Carbon::now();
    }
}
