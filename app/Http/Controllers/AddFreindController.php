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
            'receiver_id' => 'required|exists:users,id',
        ]);
    
        $sender_id = auth()->id();
        $receiver_id = $request->input('receiver_id');
    
        // Check if a request already exists
        if (AddFreind::where('sender_id', $sender_id)->where('receiver_id', $receiver_id)->exists()) {
            return response()->json(['message' => 'Friend request already sent'], 400);
        }
    
        try {
            $friendRequest = AddFreind::create([
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
                'status' => 'pending'  // Assuming 'pending' is the intended initial status
            ]);
    
            return response()->json([
                'data' => $friendRequest,
                'message' => 'Request sent successfully',
                'success' => true,
            ], 201);  // HTTP 201 Created
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send friend request',
                'error' => $e->getMessage(),
                'success' => false,
            ], 500);  // HTTP 500 Internal Server Error
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
