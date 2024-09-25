<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\WereHouseOut;
use App\Models\WereHouse;
use App\Models\WereHouseCurrent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\WereHouseOutResource;

class WereHouseOutController extends Controller
{

    public function index()
    {
        $whereHouseOut = WereHouseOutResource::collection(WereHouseOut::all());

        return response()->json($whereHouseOut, 200);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'were_house_id' => 'required|integer|exists:were_houses,id',
            'date' => 'required|date',
            'quantity' => 'required|integer|min:0',
        ])->validate();

        if(!$validatedData)
        {
            return response()->json($validatedData,412);
        }

        $wereHouse = WereHouse::findOrFail($validatedData['were_house_id']);

        if ($wereHouse) {
            $wereHouseOut = WereHouseOut::create($validatedData);

            // Update quantity in WereHouseCurrent
            $wereHouseCurrent = WereHouseCurrent::where('were_house_id', $validatedData['were_house_id'])->first();
            if ($wereHouseCurrent) {
                $wereHouseCurrent->quantity -= $validatedData['quantity'];
                $wereHouseCurrent->save();
            }

            return response()->json(['message' => 'Warehouse Out created successfully'], 201);
        }

        return response()->json(['error' => 'Failed to create warehouse out'], 422);
    }

    public function show(string $id)
    {
        $whereHouseOut = new WereHouseOutResource(WereHouseOut::findOrFail($id));

        return response()->json($whereHouseOut, 200);
    }

    public function update(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'id' => 'required|integer|exists:were_house_outs,id',
            'were_house_id' => 'required|integer',
            'date' => 'required|date',
            'quantity' => 'required|integer|min:0',
        ])->validate();

        if(!$validatedData)
        {
            return response()->json($validatedData,412);
        }

        $wereHouseOut = WereHouseOut::findOrFail($validatedData['id']);
        $wereHouse = WereHouse::findOrFail($validatedData['were_house_id']);

        if ($wereHouseOut && $wereHouse) {
            // Update quantity in WereHouseCurrent
            $wereHouseCurrent = WereHouseCurrent::where('were_house_id', $validatedData['were_house_id'])->first();
            if ($wereHouseCurrent) {
                $quantityDifference = $validatedData['quantity'] - $wereHouseOut->quantity;
                $wereHouseCurrent->quantity -= $quantityDifference;
                $wereHouseCurrent->save();
            }

            // Update WereHouseOut
            $wereHouseOut->were_house_id = $validatedData['were_house_id'];
            $wereHouseOut->date = $validatedData['date'];
            $wereHouseOut->quantity = $validatedData['quantity'];
            $wereHouseOut->save();

            return response()->json(['message' => 'Warehouse Out updated successfully'], 201);
        }

        return response()->json(['error' => 'Failed to update warehouse out'], 422);
    }

    public function destroy(string $id)
    {
        $wereHouseOut = WereHouseOut::findOrFail($id);

        if ($wereHouseOut->delete()) {
            return response()->json(['success' => 'Warehouse Out deleted successfully'], 201);
        }

        return response()->json(['error' => 'Failed to delete warehouse out'], 422);
    }
}
