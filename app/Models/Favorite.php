<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'favorites';
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'user_id',
        'menu_id',
    ];


    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
