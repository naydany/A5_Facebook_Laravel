<?php

namespace App\Http\Controllers;

use App\Models\AddFreind;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\FriendResource;

class AddFreindController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function Friends($id)
    {
        $friends = AddFreind::where('sender_id', $id)
            ->orWhere('receiver_id', $id)
            ->with('receiver')
            ->get(['id', 'receiver_id']);

        $friends = $friends->map(function ($friend) {
            return [
                'id' => $friend->id,
                'receiver_name' => $friend->receiver->name,
                'email' => $friend->receiver->email,
                'image' => $friend->receiver->image,
            ];
        });

        return response()->json([
            'friends' => $friends,
            'message' => 'Request friends successfully',
            'success' => true,
        ]);
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
                'status' => false  // Assuming 'pending' is the intended initial status
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

    public function confirmRequest(Request $request, $id)
    {
        // Find the friend request by ID
        $friendRequest = AddFreind::find($id);
        // return $id.' '.$friendRequest->receiver_id;

        // Check if the friend request exists and the authenticated user is the receiver
        if (!$friendRequest || $friendRequest->receiver_id !== auth()->id()) {
            return response()->json(['message' => 'Friend request not found or unauthorized'], 404);
        }

        // Update the status to 'confirmed'
        $friendRequest->status = true;
        $friendRequest->save();

        return response()->json([
            'data' => $friendRequest,
            'message' => 'Friend request confirmed successfully',
            'success' => true,
        ]);
    }

    public function deleteRequest(Request $request, $sender_id)
    {
        $receiver_id = auth()->id();

        // Find and delete the friend request based on sender_id and receiver_id
        $deleted = AddFreind::where('sender_id', $sender_id)
            ->where('receiver_id', $receiver_id)
            ->delete();

        if ($deleted) {
            return response()->json([
                'message' => 'Friend request deleted successfully',
                'success' => true,
            ]);
        } else {
            return response()->json([
                'message' => 'Friend request not found or unauthorized to delete',
                'success' => false,
            ], 404);
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
