<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DynamicPage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'page_title',
        'page_content',
        'status',
    ];
    protected $hidden = [
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
