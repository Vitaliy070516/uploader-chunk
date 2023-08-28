<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Eloquent\Uploadable;

class Attachment extends Model
{
    use Uploadable;

    protected $fillable = ['name', 'path'];
}
