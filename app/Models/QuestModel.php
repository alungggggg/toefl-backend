<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestModel extends Model
{
    use HasFactory;

    protected $table = 'quests';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'question',
        'type',
        'answer',
        'options',
        'weight'
    ];

    public function options(): HasMany
    {
        return $this->hasMany(OptionModel::class, 'id_question', 'options');
    }
}
