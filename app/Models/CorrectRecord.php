<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrectRecord extends Model
{
    use HasFactory;

    protected $fillable = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'file_id'];
}
