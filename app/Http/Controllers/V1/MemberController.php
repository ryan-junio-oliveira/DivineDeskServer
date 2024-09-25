<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberCollection;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Http\Resources\MemberResource;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $member = new MemberCollection(Member::all());

        if($member){

            return response()->json($member, 200);
        }

        return response()->json(['error' => 'error in search members'], 422);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'tel' => 'required|string|max:255',
            'email' => 'required|email',
            'marital_status' => 'required|string|max:255',
        ]);

        if(!$validatedData)
        {
            return response()->json($validatedData, 412);
        }

            $member = Member::create($validatedData);
            if($member)
            {
                return response()->json(['sucess'=> 'members created with success'], 201);
            }

            return response()->json(['error' => 'erro a created members'], 422);



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member =  new MemberResource(Member::findOrFail($id));

        if($member)
        {
            return response()->json($member, 200);
        }

        return response()->json(['error' => ' error in members'], 422);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:members,id',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'tel' => 'required|string|max:255',
            'email' => 'required|email',
            'marital_status' => 'required|string|max:255',
        ]);

        if(!$validatedData)
        {
            return response()->json($validatedData, 412);
        }


        $member = Member::findOrFail($validatedData['id']);

        if($member)
        {
            $member->name = $validatedData['name'];
            $member->address = $validatedData['address'];
            $member->tel = $validatedData['tel'];
            $member->email = $validatedData['email'];
            $member->marital_status = $validatedData['marital_status'];

            if($member->save())
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
        $destroy = Member::find($id);

        if($destroy->delete()){

            return response()->json(['success' => 'success as delete members'],201);
        }

          return response()->json(['error' => 'error as delete members'], 422);
    }
}
