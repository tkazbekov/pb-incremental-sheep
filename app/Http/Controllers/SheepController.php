<?php

namespace App\Http\Controllers;
use App\Sheep;
use App\Http\Resources\SheepResource;
use App\Http\Resources\SheepsResource;
use Illuminate\Http\Request;

class SheepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $result = Sheep::pen($request->pen_id)->get();
        return new SheepsResource($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sheep = Sheep::create([
            'pen_id' => $request->pen_id,
        ]);
        return new SheepResource($sheep);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sheep $sheep)
    {
        SheepResource::withoutWrapping();
        return new SheepResource($sheep);
    }

    public function update(Request $request, Sheep $sheep)
    {
        $sheep->update($request->only(['pen_id']));
        return new SheepResource($sheep);
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
        Sheep::truncate();
      else 
        Sheep::findOrFail($id)->delete();
      return new SheepsResource(Sheep::all());
    }
}
