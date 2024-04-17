<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoxChatController extends Controller
{
    public function index($id){
        $room = Room::find($id);
        $listMembers = $room->users;
        $ownerRoom = $room->owner;
        $listMembers = $listMembers->merge([$ownerRoom]);
        $messages = $room->messages;
        $me = Auth::user();
        return view('pages.boxChat', ["room" => $room, 'messages'=>$messages, 'listMembers'=>$listMembers, 'me' => $me]);
    }
    public function sendMess(Request $request){
        $input = $request->all();
        $message = Message::create([
            'content' => $input['content'],
            'type' => $input['type'],
            'room_id' => $input['room_id'],
            'user_id' => Auth::user()->id,
        ]);
        event(new MessageSent($request->all(), $input['room_id']));
        return response()->json($message,200);
    }
    public function sendImage(Request $request){
//        if($request->hasFile('content_img')){
//            $image = $request->file('content_img');
//            $room_id = $request->input('room_id');
//            $filename = time() . '_' . $image->getClientOriginalName();
//            $path = $image->storeAs('public/images', $filename);
//            $publicPath = 'storage/images'.$filename;
//            $message = Message::create([
//                'content' => $publicPath,
//                'type' => 'image',
//                'room_id' => $room_id,
//                'user_id' => Auth::user()->id,
//            ]);
//            event(new MessageSent($request->all), $room_id);
//            return response()->json($message, 200);
//        }
    }
}
