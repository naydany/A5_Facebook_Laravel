<?php

namespace App\Http\Controllers;

use App\Models\AddFreind;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AddFreindController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function sendRequest(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
        ]);
        
        
        $sender_id = $request->input('sender_id');
        $receiver_id = $request->input('receiver_id');

        // // Check if a request already exists
        if (AddFreind::where('sender_id', $sender_id)->where('receiver_id', $receiver_id)->exists()) {
            return response()->json(['message' => 'Friend request already sent'], 400);
        }
        $add_freinds = new AddFreind();

        try{    
            $friendRequest = $add_freinds::create([
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
            ]);
            return response()->json([
                'data' => $friendRequest,
                'message' => 'Request sent successfully',
                'success' => true,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'data' => $e->getMessage(),
               'message' => $e->getMessage(),
               'success' => false,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AddFreind $addFreind)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AddFreind $addFreind)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AddFreind $addFreind)
    {
        //
    }
}
