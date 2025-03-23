<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BundlerModel extends Model
{
    use HasFactory;
    protected $table = 'bundler';

    protected $fillable = [
        'id_exam',
        'id_quest',
    ];

    public function quest(): HasOne
    {
        return $this->hasOne(QuestModel::class, 'uuid', 'id_quest');
    }


    public function exam(): HasOne
    {
        return $this->hasOne(QuestModel::class, 'uuid', 'id_exam');
    }

}
