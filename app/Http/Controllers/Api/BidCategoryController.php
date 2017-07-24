<?php

namespace App\Http\Controllers\Api;

use App\BidCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BidCategoryController extends Controller
{
	public function getList()
	{
		return BidCategory::all();
	}
}