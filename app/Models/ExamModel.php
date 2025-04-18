<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamModel extends Model
{
    use HasFactory;
    protected $table = 'exam';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'name',
        'code',
        'access',
        'expired',
    ];

    public function quest()
    {
        return $this->hasMany(BundlerModel::class, 'id_exam', 'uuid');
    }
}
