<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomModel extends Model
{
    use HasFactory;
    protected $table = 'room';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'id_exam',
        'id_user',
    ];

    public function exam(): HasMany
    {
        return $this->hasMany(ExamModel::class, 'uuid', 'id_exam');
    }
}
