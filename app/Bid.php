<?php

namespace App;

use Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = ['name', 'fields', 'category_id', 'published', 'responsible_id'];

    public function category()
    {
    	return $this->belongsTo(BidCategory::class);
    }

    public static function store($request)
    {
    	$submited = $request->all();
    	$submited['fields'] = '[';
        foreach($submited['select'] as $index => $select)
        {
            switch ($select) {
                case 'files':
                    $files = $request->file('files-'.$index);
                    $bid_name = \Slug::make($request->name);
                    $path = 'public/bids/'.$bid_name.'/';
                    $jPath = 'storage/app/public/bids/'.$bid_name.'/';
                    $jFiles = '';
                    if(is_array($files) && !empty($files))
                    {
                        foreach ($files as $file) {                        
                            Storage::put($path.$file->getClientOriginalName(), file_get_contents($file));
                            $jFiles .= '{ "src":"'.$jPath.$file->getClientOriginalName().'"},';
                        }    
                    }
                    elseif(isset($files))
                    {
                        Storage::put($path.$files->getClientOriginalName(), file_get_contents($files));
                        $jFiles .= '{ "src":"'.$jPath.$files->getClientOriginalName().'"},';
                    }
                    $submited['fields'] .= 
                        '{ "field":"'.$select.
                        '", "label":"'. $submited['label-'.$index].
                        '", "files":['. rtrim($jFiles, ',').
                        '], "box_type":"'. $submited['box_type-'.$index].
                        '", "required": 0'.
                        '},';
                    break;
                case 'texts':
                    $texts = '';
                    $requested_texts = explode(';', $submited['texts-'.$index]);                   
                    foreach ($requested_texts as $text) {                        
                        if($text)                   
                            $texts .= '{ "text":"'.$text.'"},';                        
                    }    
                    $submited['fields'] .= 
                        '{ "field":"'.$select.
                        '", "label":"'. $submited['label-'.$index].
                        '", "texts":['. rtrim($texts, ',').
                        '], "box_type":"'. $submited['box_type-'.$index].
                        '", "required": 0'.
                        '},';
                    break;
                case 'dropdown':
                    $texts = '';
                    $requested_texts = explode(';', $submited['texts-'.$index]);                   
                    foreach ($requested_texts as $text) {     
                        if($text)                   
                            $texts .= '{ "text":"'.$text.'"},';                        
                    }    
                    $submited['fields'] .= 
                        '{ "field":"'.$select.
                        '", "label":"'. $submited['label-'.$index].
                        '", "texts":['. rtrim($texts, ',').                        
                        '], "required":'. (isset($submited['required-'.$index]) ? 1 : 0).
                        '},';
                    break;
                case 'number':
                    $submited['fields'] .= 
                        '{ "field":"'.$select.
                        '", "label":"'. $submited['label-'.$index].
                        '", "min":'. $submited['min-'.$index].
                        ', "max":'. $submited['max-'.$index].
                        ', "step":'. $submited['step-'.$index].
                        ', "required":'. (isset($submited['required-'.$index]) ? 1 : 0).                 
                        '},';
                    break;
                
                default:                    
                    $submited['fields'] .= 
                    '{ "field":"'.$select.
                    '", "label":"'. $submited['label-'.$index].
                    '", "required":'. (isset($submited['required-'.$index]) ? 1 : 0).
                    '},';
                    break;
            }
        }
        $submited['fields'] = rtrim($submited['fields'], ',').']';
        $submited['category_id'] = (int) $submited['category_id'];
        $submited['published'] = isset($submited['published']);
        Bid::create($submited);
    }

    public function email()
    {
        return RoleDepartmentsEmail::where('role_id', $this->responsible_id)
                        ->where('city_id', Auth::user()->city_id)
                        ->where('department_id', Auth::user()->department_id)
                        ->first();
    }
}
