<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlertCollection;
use App\Http\Resources\AlertResource;
use Illuminate\Http\Request;
use App\Models\Alert;

use function Laravel\Prompts\alert;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alert = Alert::all();

        if($alert)
        {
           $data = new AlertCollection($alert);

           return response()->json($data,200);
        }

        return response()->json(['error' => 'error in list alert']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([

            'message' => 'required|string'
        ]);

        if(!$validateData)
        {
            return response()->json($validateData,412);
        }

        $data =  Alert::create($validateData);

        if($data)
        {
            return response()->json([
             'success' => 'create alert sucessfully'
            ]);
        }

        return response()->json([
            'error' => 'error in created alert'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $alert = Alert::find($id);

        if($alert)
        {
            $data = new AlertResource($alert);

            return response()->json($data, 200);
        }

        return response()->json(['error' => ' error in show alert'], 422);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validateData = $request->validate(
            ['id' => 'required|integer|exists:alert,id',
             'message' => 'required|string']
        );

        if(!$validateData)
        {
            return response()->json($validateData, 412);
        }

        $alert = Alert::find($validateData['id']);

        if($alert)
        {
            $alert->message = $validateData['message'];

            if($alert->save())
            {
                return response()->json(['success' => 'update message sucessfully'], 201);
            }

            return response()->json(['error' => 'error in update message']);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $alert = Alert::find($id);

        if(!$alert)
        {
            return response()->json(['error' => 'error in try delete the alert']);
        }

        if($alert->delete())
        {
           return response()->json(['success' => 'alert delete sucessfully'], 201);
        }

        return response()->json(['error' => 'error in try delete the alert']);

    }
}
