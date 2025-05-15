<?php

namespace App\Http\Controllers;
use Ramsey\Uuid\Uuid;
use App\Models\ExamModel;
use App\Models\RoomModel;
use App\Models\ScoreModel;
use App\Models\BundlerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class ExamController extends Controller
{
    public function index(Request $request)
    {
        try {

            $data = ExamModel::with('quest.quest.options')->get();

            if($request->id) {
                $exam = ExamModel::find($request->id);
                $exam->reading = BundlerModel::where(['id_exam' => $exam->uuid] )->with(["quest", "quest.options"])->get("id_quest")->pluck("quest")->map(function($item){
                    if($item->type === "reading"){
                        return $item;
                    }
                })->filter()->values();

                $exam->listening = BundlerModel::where(['id_exam' => $exam->uuid] )->with(["quest", "quest.options"])->get("id_quest")->pluck("quest")->map(function($item){
                    if($item->type === "listening"){
                        return $item;
                    }
                })->filter()->values();
                $exam->structure = BundlerModel::where(['id_exam' => $exam->uuid] )->with(["quest", "quest.options"])->get("id_quest")->pluck("quest")->map(function($item){
                    if($item->type === "structure"){
                        return $item;
                    }
                })->filter()->values();

                if(!$exam) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Exam not found'
                    ], 404);
                }
                $data = $exam;
            }



            if($request->id_user){

                $id = RoomModel::where("id_user", Crypt::decryptString($request->id_user))->get('id_exam')->pluck('id_exam');

                $exam = ExamModel::where("uuid", $id)->first();
                $exam->reading = BundlerModel::where(['id_exam' => $exam->uuid] )->with(["quest", "quest.options"])->get("id_quest")->pluck("quest")->map(function($item){
                    if($item->type === "reading"){
                        return $item;
                    }
                })->filter()->values();

                $exam->listening = BundlerModel::where(['id_exam' => $exam->uuid] )->with(["quest", "quest.options"])->get("id_quest")->pluck("quest")->map(function($item){
                    if($item->type === "listening"){
                        return $item;
                    }
                })->filter()->values();
                $exam->structure = BundlerModel::where(['id_exam' => $exam->uuid] )->with(["quest", "quest.options"])->get("id_quest")->pluck("quest")->map(function($item){
                    if($item->type === "structure"){
                        return $item;
                    }
                })->filter()->values();

                $data = $exam;   
            }

            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $exam = new ExamModel();
            $exam->uuid = Uuid::uuid4();;
            $exam->name = $request->name;
            $exam->code = self::generateRandomCode(8);
            $exam->access = $request->access;
            $exam->expired = $request->expired;
            $exam->save();

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

    function generateRandomCode($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomCode = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomCode .= $characters[rand(0, $charactersLength - 1)];
        }
    
        return $randomCode;
    }

    public function edit(Request $request)
    {
        try {
            $exam = ExamModel::find($request->uuid);
            $exam->name = $request->name;
            $exam->access = $request->access;
            $exam->expired = $request->expired;
            $exam->save();

            if ($request->bundler && count($request->bundler) > 0) {
                BundlerModel::where('id_exam', $exam->uuid)->delete();
                foreach($request->bundler as $bundle) {
                    $bundler = new BundlerModel();
                    $bundler->uuid = Uuid::uuid4();
                    $bundler->id_exam = $request->uuid;
                    $bundler->id_quest = $bundle["id_quest"];
                    $bundler->save();
                } 
            }else {
                BundlerModel::where('id_exam', $exam->uuid)->delete();
            }     


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

    public function destroy(Request $request)
    {
        try {
            $exam = ExamModel::find($request->uuid);
            if(!$exam){
                return response()->json([
                    'status' => false,
                    'message' => 'Exam not found'
                ], 404);
            }
            $exam->delete();

            BundlerModel::where('id_exam', $exam->uuid)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Exam deleted successfully'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
}
