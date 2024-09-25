<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Tithe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TitheResource;
use App\Http\Resources\TitheCollection;

class TitheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = new TitheCollection(Tithe::all());

        if($data)
        {
            return response()->json($data);
        }

        return response()->json(['error' => 'error in find tithe']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = Auth::id();

        $validateData = $request->validate([
        'member_id' => 'required|integer|exists:members,id',
        'value' => 'required|numeric|min:1|max:50',
        'date' => 'required|date',
    ]);

        $validateData['user_id'] = $id;

        if(!$validateData)
        {
            return response()->json($validateData, 412);
        }

            $tithe = Tithe::create($validateData);

            if($tithe)
            {
                return response()->json(['success' => 'create tithe with success'],201);
            }

            return response()->json(['error' => 'create tithe with success'], 422);


        return response()->json(['error' => 'create tithe with success'], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $tithe = Tithe::findOrFail($id);

        if($tithe)
        {
            $data = new TitheResource($tithe);

            return response()->json($data);
        }

        return response()->json(['error' => 'error to find tithe'], 422);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = Auth::id();

        $validateData = $request->validate([
            'id' => 'required|integer|exists:tithe,id',
            'member_id' => 'required|integer|exists:members,id',
            'value' => 'required|numeric|min:1|max:50',
            'date' => 'required|date',
        ]);

        if(!$validateData)
        {
            return response()->json($validateData, 412);
        }

        $validateData['user_id'] = $id;

        if($validateData)
        {
            $tithe = Tithe::findOrFail($validateData['id']);

            if($tithe)
            {
                $tithe->member_id = $validateData['member_id'];
                $tithe->value = $validateData['value'];
                $tithe->date = $validateData['date'];

                if($tithe->save())
                {
                    return response()->json(['success' => 'success to update tithe'], 201);
                }

                return response()->json(['error' => 'error to update tithe']);
            }

            return response()->json(['error' => 'error to update tithe']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $destroy = Tithe::find($id);

        if($destroy->delete()){

            return response()->json(['success' => 'success as delete tithe'],201);
        }

          return response()->json(['error' => 'error as delete tithe'], 422);
    }
}
