<?php

namespace App\Modules\Manage\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FeedbackModel extends Model
{
    protected $table = 'feedback';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'uid',
        'phone',
        'desc',
        'type',
        'created_time',
        'handle_time',
        'status',
        'replay'
    ];

    public $timestamps = false;


}
