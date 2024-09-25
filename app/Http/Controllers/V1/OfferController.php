<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\OfferCollection;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index()
    {
        $offer = new OfferCollection(Offer::all());

        if($offer){

            return response()->json($offer, 200);
        }

        return response()->json(['error' => 'error in search offer'], 422);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'value' => 'required|integer',
            'date' => 'required|date',
    ]);

        if(!$validateData)
        {
            return response()->json($validateData, 412);
        }


        if($validateData)
        {
            $id = Auth::id();

            $data['user_id'] = $id;

            $member = Offer::create($validateData);

            if($member)
            {
                return response()->json(['sucess'=> 'offer created with success'], 201);
            }

            return response()->json(['error' => 'erro a created offer'], 422);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $offer =  new OfferResource(Offer::findOrFail($id));

        if($offer)
        {
            return response()->json($offer, 200);
        }

        return response()->json(['error' => ' error in members'], 422);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validateData = $request->validate([
            'id' => 'required|integer|exists:members,id',
            'value' => 'required|integer',
            'date' => 'required|date',
    ]);

        if(!$validateData)
        {

            return response()->json($validateData, 412);
        }


        $offer = Offer::findOrFail($validateData['id']);

        if($offer)
        {
            $offer->value = $validateData['value'];
            $offer->date = $validateData['date'];

            if($offer->save())
            {
                return response()->json(['message' => 'success as created a members'], 201);
            }

            return response()->json(['error' => 'error as created members'], 422);
        }

            return response()->json(['error' => 'error as created members'], 422);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroy = Offer::find($id);

        if($destroy->delete()){

            return response()->json(['success' => 'success as delete offer'],201);
        }

          return response()->json(['error' => 'error as delete offer'], 422);
    }
}
