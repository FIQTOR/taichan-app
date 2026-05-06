<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetToken extends Model
{
    use HasFactory;
    protected $table = 'reset_tokens';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'email',
        'token'
    ];
}
