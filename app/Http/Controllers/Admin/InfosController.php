<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Info;
use Illuminate\Http\Request;

class InfosController extends Controller
{
    public function index()
    {
    	return view('admin.infos');
    }

    public function store()
    {
    	Info::store();
    	return redirect('/admin/infos')->with([
                'message'    => "Свободные блоки обновлены",
                'alert-type' => 'success',
            ]);
    }
}
