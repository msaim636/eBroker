<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAppTimezone;
class Setting extends Model
{
    use HasFactory, HasAppTimezone;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $table = "settings";

    protected $fillable = [
        'type',
        'data'
    ];
    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function getDataAttribute($value){
        if($this->type == 'default_language'){
            if($value == 'en-new'){
                return 'en';
            }
        }
        return $value;
    }
}
