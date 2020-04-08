<?php

namespace Gerfey\OnlineAssistant\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Choice extends Model
{
    protected $table = 'choices';

    public $timestamps = false;

    protected $fillable = [
        'title', 'keywords'
    ];

    protected $hidden = [
        'id'
    ];

    protected $casts = [
        'title' => 'string',
        'keywords' => 'json'
    ];
}
