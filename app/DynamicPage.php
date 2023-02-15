<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicPage extends Model
{
    use HasFactory;
    protected $fillable = [
        'html_content',
        'order',
        'menu_title',
    ];

}
