<?php

namespace App\Http\Controllers;
use App\Pen;
use App\Http\Resources\PenResource;
use App\Http\Resources\PensResource;
use Illuminate\Http\Request;

class PenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PensResource(Pen::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pen = new Pen;
        $pen->save();
        return new PenResource($pen);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pen $pen)
    {
        PenResource::withoutWrapping();

        return new PenResource($pen);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
                if ($id == 'all')
                    Pen::truncate();
                else 
                    Pen::findOrFail($id)->delete();
                return response()->json(null, 204);
    }
}
