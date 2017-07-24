<?php

namespace App\Http\Controllers\Admin;

use App\Bid;
use App\BidCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.bids.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bids.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Repsponse

     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|unique:bids|max:255',
            'files.*' => 'required',
        ]);
        Bid::store($request);
        return redirect('/admin/bids/')->with([
                'message'    => "Заявка добавлена",
                'alert-type' => 'success',
            ]);      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bid = Bid::find($id);
        $categories = BidCategory::all();
        return view('admin.bids.edit', compact('bid', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'name' => 'required|max:255',
        ]);
        $bid = Bid::find($id);
        $bid->name = $request->name;
        $bid->responsible_id = $request->responsible_id;
        $bid->category_id = (int) $request->category_id;
        $bid->published = isset($request->published);
        $bid->save();
        return redirect('/admin/bids/')->with([
                'message'    => "Заявка обновлена",
                'alert-type' => 'success',
            ]);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bid::findOrFail($id)->delete();

        return back();
    }
}
