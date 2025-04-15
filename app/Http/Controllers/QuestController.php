<?php

namespace App\Http\Controllers;

use App\Models\QuestModel;
use App\Models\OptionModel;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class QuestController extends Controller
{
    public function index(Request $request)
    {
        try {
            if($request->id) {
                $data = QuestModel::find($request->id)->with("options")->get();
                if(!$data) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Quest not found'
                    ], 404);
                }

                
                return response()->json([
                    'status' => true,
                    'data' => $data,
                ]);
            }

            if($request->type) {
                $data = QuestModel::where("type", $request->type)->with("options")->get();
                if(!$data) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Quest not found'
                    ], 404);
                }
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
            $quest->question = $request->question;
            $quest->type = $request->type;
            $quest->answer = $request->answer;
            $quest->weight = $request->weight;
            $quest->options = $uuid;
            foreach ($request->options as $option) {
                Self::optionStore($uuid, $option["option"]);
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
        OptionModel::where("id_question", $id)->delete();
        $option = new OptionModel();
        $option->id_question = $id;
        $option->options = $raw;
        $option->save();
    }

    public function edit(Request $request){
        try {
            $quest = QuestModel::find($request->id);            
            $quest->question = $request->question;
            $quest->type = $request->type;
            $quest->answer = $request->answer;
            $quest->weight = $request->weight;
            $quest->save(); 

            foreach ($request->options as $option) {
                Self::optionEdit($request->id, $option["option"]);
            }


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
}
