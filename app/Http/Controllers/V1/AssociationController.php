<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Association;
use Illuminate\Http\Request;
use App\Http\Resources\AssociationCollection;
use App\Http\Resources\AssociationResource;
use Illuminate\Http\Client\ResponseSequence;
use Ramsey\Uuid\Type\Integer;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Association::all();

        if($data)
        {
            $result =  new AssociationCollection($data);

            return response()->json($data,201);
        }

        return response()->json(['error' => 'error in list association']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if(!$validatedData)
        {
            return response()->json($validatedData, 412);
        }

            $association = Association::create($validatedData);
            if($association)
            {
                return response()->json(['sucess'=> 'association created with success'], 201);
            }

            return response()->json(['error' => 'erro a created association'], 422);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $association = Association::find($id);

        if($association)
        {
            $data = new AssociationResource($association);

            return response()->json($data, 200);
        }

        return response()->json(['error' => 'error in show association']);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:association,id',
            'name' => 'required|string'
        ]);

        if(!$validatedData)
        {
            return response()->json($validatedData);
        }

         $association = Association::find($validatedData['id']);

         if($association)
         {
            $association->name = $validatedData['name'];

            if($association->save())
            {
                return response()->json(['success' => ' update sucessfully'],201);
            }

            return response()->json(['error' => 'error in association update']);
         }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroy = Association::find($id);

        if($destroy->delete()){

            return response()->json(['success' => 'success as delete association'],201);
        }

        return response()->json(['error' => 'error in delete association'],422);
    }

}
