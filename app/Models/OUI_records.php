<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OUI_records extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'Assignment',
        'Organization_name',
    ];
}
