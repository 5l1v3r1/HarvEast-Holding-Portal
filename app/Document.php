<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['name', 'link', 'category_id', 'descrtiption'];    

    public function category()
    {
    	return $this->belongsTo(DocumentCategory::class, 'category_id');
    }

    public function categoryId()
    {
    	return $this->belongsTo(DocumentCategory::class, 'category_id');
    }

}
