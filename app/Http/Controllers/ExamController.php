<?php

namespace App\Http\Controllers;
use Ramsey\Uuid\Uuid;
use App\Models\ExamModel;
use App\Models\ScoreModel;
use App\Models\OptionModel;
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

            $allOptions = OptionModel::all();
            $data = ExamModel::with('quest.quest.options')->get()->map(function ($exam) use ($allOptions) {
                $quests = $exam->quest->map(function ($bundler) {
                    return $bundler->quest;
                })->filter();
            
                // Urutkan berdasarkan type yang muncul pertama kali
                $typeOrder = $quests->pluck('type')->unique()->values();
            
                // Urutkan quest sesuai typeOrder
                $sortedQuests = $quests->sortBy(function ($quest) use ($typeOrder) {
                    return $typeOrder->search($quest->type);
                })->values();
            
                $resultQuests = collect();
                $lastType = null;
            
                foreach ($sortedQuests as $quest) {
                    if ($quest->type !== $lastType) {
                        $resultQuests->push([
                            'type' => $quest->type,
                            'text' => 'Kerjakan soal bertipe ' . ucfirst(strtolower($quest->type)),
                        ]);
                        $lastType = $quest->type;
                    }
            
                    $options = $allOptions->filter(function ($option) use ($quest) {
                        return $option->id_question === $quest->options;
                    })->map(function ($option) {
                        return [
                            'uuid' => $option->uuid,
                            'id_question' => $option->id_question,
                            'options' => $option->options,
                        ];
                    })->values();
            
                    // Tambahkan quest-nya + options relasinya diolah
                    $resultQuests->push([
                        'uuid' => $quest->uuid,
                        'question' => $quest->question,
                        'type' => $quest->type,
                        'answer' => $quest->answer,
                        'options' => $options,
                        'weight' => $quest->weight,
                    ]);
                }
            
                return [
                    'uuid' => $exam->uuid,
                    'name' => $exam->name,
                    'code' => $exam->code,
                    'access' => $exam->access,
                    'expired' => $exam->expired,
                    'quests' => $quest->uuid,
                    'quest' => $resultQuests,
                ];
            });
            
            

            

            if($request->id_exam){
                return response()->json([
                    'status' => "test",
                    'data' => ScoreModel::where("id_exam", $request->id_exam)->get()
                ]);
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
