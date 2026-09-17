<?php

namespace App\Models;

use App\Traits\HasAppTimezone;
use App\Services\HelperService;
use App\Traits\ManageTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, HasAppTimezone, ManageTranslations;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $table = 'categories';

    protected $fillable = [
        'category',
        'image',
        'status',
        'sequence',
        'parameter_types'

    ];
    protected $hidden = [
        'updated_at'
    ];

    public function getParametersAttribute()
    {
        $parameterTypes = explode(',', $this->parameter_types);
        if (!empty($parameterTypes)) {
            $parameters = parameter::whereIn('id', $parameterTypes)->with('translations')->get();
            $sortedParameters = $parameters->sortBy(function ($item) use ($parameterTypes) {
                return array_search($item->id, $parameterTypes);
            });
            return $sortedParameters;
        }
        return [];
    }

    public function parameter()
    {
        return $this->hasMany(parameter::class,'id','parameter_types');
    }
    public function properties()
    {
        return $this->hasMany(Property::class,'category_id','id');
    }

    public function getImageAttribute($image)
    {
        return $image != "" ? url('') . config('global.IMG_PATH') . config('global.CATEGORY_IMG_PATH') . $image : '';
    }

    /**
     * Translations relationship
     */
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }
    
    /**
     * Get translated name attribute
     */
    public function getTranslatedNameAttribute()
    {
        return HelperService::getTranslatedData($this, $this->category, 'category');
    }
}
