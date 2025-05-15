<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\ExamModel;
use App\Models\RoomModel;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    //
    public function enterRoom(Request $request)
    {
        try {
            $exam = ExamModel::where('code', $request->code)->first();
            if(!$exam){
                return response()->json([
                    'status' => false,
                    'message' => 'Exam not found'
                ], 404);
            }

            if(RoomModel::where("id_user", $request->user()->id)->where("id_exam", $exam->uuid)->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => 'User already in room'
                ], 409);
            }

            $room = new RoomModel();
            $room->uuid = Uuid::uuid4();
            $room->id_exam = $exam->uuid;
            $room->id_user = $request->user()->id;
            $room->save();
            
            
            return response()->json([
                'status' => true,
                'data' => $exam
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function exitRoom(Request $request)
    {
        try{
            $user = RoomModel::where(["id_user" => $request->user()->id, "id_exam" => $request->id_exam])->first();
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'You have exited the exam room'
            ]);
        }catch(\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
