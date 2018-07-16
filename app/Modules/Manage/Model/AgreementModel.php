<?php

namespace  App\Modules\Manage\Model;

use Illuminate\Database\Eloquent\Model;

class AgreementModel extends Model
{
    
    protected $table = 'agreement';
    protected $primaryKey = 'id';


    protected $fillable = [
        'id','name','content','created_at','updated_at','code_name'
    ];

    public $timestamps = false;


}
