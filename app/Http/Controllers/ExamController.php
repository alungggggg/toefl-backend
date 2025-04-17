<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\ExamModel;
use App\Models\User;
use App\Models\BundlerModel;
use Illuminate\Http\Request;


class ExamController extends Controller
{
    public function index(Request $request)
    {
        try {
            if($request->id) {
                $exam = ExamModel::find($request->id);
                $exam->quest = BundlerModel::where('id_exam', $exam->uuid)->with(["quest", "quest.options"])->get("id_quest")->pluck("quest");
                if(!$exam) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Exam not found'
                    ], 404);
                }
                return response()->json([
                    'status' => true,
                    'data' => $exam,
                ]);
            }
            $data = ExamModel::with('quest.quest.options')->get()->map(function ($exam) {
                return [
                    'uuid' => $exam->uuid,
                    'name' => $exam->name,
                    'code' => $exam->code,
                    'access' => $exam->access,
                    'expired' => $exam->expired,
                    'bundler' => $exam->quest->map(function ($bundler) use ($exam) {
                        return [
                            $bundler->quest, 
                        ];
                    }),
                ];
            });

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
        // return $request->all();
        try {
            $exam = ExamModel::find($request->uuid);
            $exam->name = $request->name;
            $exam->access = $request->access;
            $exam->expired = $request->expired;
            $exam->save();

            foreach($request->bundler as $bundle) {
                $bundler = new BundlerModel();
                $bundler->uuid = Uuid::uuid4();
                $bundler->id_exam = $request->uuid;
                $bundler->id_quest = $bundle["id_quest"];
                $bundler->save();
            }

            return response()->json([
                'status' => true,
                'data' => $bundler
            ]);            

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


            $user = User::find($request->user()->id);
            $user->exam = $exam->uuid;
            $user->save();

            
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
            $user = User::find($request->user()->id);
            $user->exam = null;
            $user->save();

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
