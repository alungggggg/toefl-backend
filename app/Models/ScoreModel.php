<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreModel extends Model
{
    use HasFactory;
    protected $table = 'score';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'uuid',
        'id_user',
        'score',
        'status',
    ];

}
