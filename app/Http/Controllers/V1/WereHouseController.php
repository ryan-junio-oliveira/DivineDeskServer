<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\WereHouseCollection;
use App\Http\Resources\WereHouseResource;
use App\Models\WereHouse;
use Illuminate\Http\Request;

class WereHouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $whereHouse = new WereHouseCollection(WereHouse::all());

        if($whereHouse){

            return response()->json($whereHouse, 200);
        }

        return response()->json(['error' => 'error in search whereHouse'], 412);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'quantity' => 'required|integer|min:0',
        ]);

        if(!$validatedData)
        {
            return response()->json($validatedData, 412);
        }

        $whereHouse = WereHouse::create($validatedData);

            if($whereHouse)
            {
                return response()->json(['sucess'=> 'Warehouse create successfully'], 201);
            }

            return response()->json(['error' => 'Failed to create warehouse'], 422);



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $whereHouse =  new WereHouseResource(WereHouse::findOrFail($id));

        if($whereHouse)
        {
            return response()->json($whereHouse, 200);
        }

        return response()->json(['error' => 'Failed to show warehouse'], 422);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'id' => 'required|exists:were_houses,id',
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'quantity' => 'required|integer|min:0',
        ]);

        if(!$validatedData)
        {
            return response()->json($validatedData,412);
        }


        $whereHouse = WereHouse::findOrFail($validatedData['id']);


        $whereHouse->name = $validatedData['name'];
        $whereHouse->quantity = $validatedData['quantity'];
        $whereHouse->date = $validatedData['date'];


        if ($whereHouse->save()) {
            return response()->json(['success' => 'Warehouse updated successfully'], 201);
        } else {
            return response()->json(['error' => 'Failed to update warehouse'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroy = WereHouse::find($id);

        if($destroy->delete()){

            return response()->json(['success' => 'Warehouse delete successfully'],201);
        }

          return response()->json(['error' => 'Failed to delete warehouse'], 422);
    }
}
