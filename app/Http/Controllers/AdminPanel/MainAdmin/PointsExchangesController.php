<?php

namespace App\Http\Controllers\AdminPanel\MainAdmin;
use App\Http\Controllers\Controller;
use App\Models\PointsExchange;
use Illuminate\Http\Request;
class PointsExchangesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['points_exchanges'] = PointsExchange::latest()->get();
        return view('main_admin.points.points_exchanges', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $add_point = PointsExchange::create($data);
        if ($add_point) {
            session()->flash('success', trans('messages.Added'));
            return redirect()->back();
        }
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
        //
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
        $edit_point = PointsExchange::where('id', $id)->first();
        $data = $request->all();
        $edit_point->update($data);
        session()->flash('success', trans('messages.updated'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $point = PointsExchange::find($id);
        if (!$point) {
            return response()->json(['status' => false, 'message' => 'النقاط غير موجود'], 404);
        }
        // تنفيذ الحذف
        $point->delete();
        return response()->json(['status' => true, 'message' => trans('messages.deleted')]);
    }
}
