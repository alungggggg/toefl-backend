<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\QuestModel;
use App\Models\OptionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class QuestController extends Controller
{
    public function index(Request $request)
    {
        try {
            if($request->id) {
                $quest = QuestModel::where( "uuid",$request->id,)->with("options")->first();
                if(!$quest) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Quest not found'
                    ], 404);
                }

                return response()->json([
                    'status' => true,
                    'data' => $quest
                ]);
            }

            if($request->type){
                $quest = QuestModel::where("type", $request->type)->with("options")->get();
                if(!$quest) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Quest not found'
                    ], 404);
                }
                return response()->json([
                    'status' => true,
                    'data' => $quest
                ]);
            }


            return response()->json([
                'status' => true,
                'data' => QuestModel::with("options")->get()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
        
    }

    public function optionStore($uuid, $raw){
        $option = new OptionModel();
        $option->uuid = Uuid::uuid4();
        $option->id_question = $uuid;
        $option->options = $raw;
        $option->save();
    }

    public function store(Request $request)
    {
        try {
            $quest = new QuestModel();
            
            $uuid = Uuid::uuid4();
            $quest->uuid = $uuid;

            $question = $request->question;

            if($request->file('question')) {
                $question = $request->file('question'); 
                $destinationPath = 'audio/';
                $audio = date('YmdHis') . "." . $question->getClientOriginalExtension();
                $question->move($destinationPath, $audio);
                $question = $audio;
            }

            $quest->question = $question;
            $quest->type = $request->type;
            $quest->answer = $request->answer;
            $quest->weight = $request->weight;
            $quest->options = $uuid;
            foreach ($request->options as $option) {
                Self::optionStore($uuid, $option["options"]);
            }
            $quest->save();

            return response()->json([
                'status' => true,
                'message' => 'Quest created successfully'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request){
        try {
            if($request->id) {
                $quest = QuestModel::find($request->id);
                $quest->options()->delete();
                $quest->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Quest deleted successfully'
                ]);
            }
            QuestModel::truncate();
            OptionModel::truncate();
            
            return response()->json([
                'status' => true,
                'message' => 'Quest has successfully truncated'
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function optionEdit($id, $raw){
        $option = new OptionModel();
        $option->uuid = Uuid::uuid4();
        $option->id_question = $id;
        $option->options = $raw;
        $option->save();
    }

    public function edit(Request $request){
        try {
            $quest = QuestModel::find($request->uuid);
            $question = $request->question;
            
            if($quest->type == "audio" && $request->file('question')){       

                    if (File::exists("audio/" . $quest['question'])) {
                        File::delete("audio/" . $quest['question']);
                    }

                    $question = $request->file('question'); 
                    $destinationPath = 'audio/';
                    $audio = date('YmdHis') . "." . $question->getClientOriginalExtension();
                    $question->move($destinationPath, $audio);
                    $question = $audio;
                
            } 
            $quest->type = $request->type;
            $quest->answer = $request->answer;
            $quest->weight = $request->weight;
            $quest->save(); 

            OptionModel::where("id_question", $request->uuid)->delete();

            foreach ($request->options as $option) {
                Self::optionEdit($request->uuid, $option["options"]);
            }


            return response()->json([
                'status' => true,
                'message' => 'Quest edited successfully'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
