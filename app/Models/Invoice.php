<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'invoices';
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'user_id',
        'token',
        'menus',
        'table_number',
        'total_price',
        'payment_method',
        'status',
        'already_paid',
    ];
}
