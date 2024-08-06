<?php

namespace App\Models;

use App\Http\Traits\NotificationFirebaseTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgoraRoom extends Model
{
    use HasFactory,NotificationFirebaseTrait;

    protected $guarded=[];

}
