<?php

namespace App\Models;

use App\Traits\HasAppTimezone;
use App\Services\HelperService;
use App\Traits\ManageTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OutdoorFacilities extends Model
{
    use HasFactory, HasAppTimezone, ManageTranslations;
    protected $table = 'outdoor_facilities';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public function getImageAttribute($image)
    {
        return $image != "" ? url('') . config('global.IMG_PATH') . config('global.FACILITY_IMAGE_PATH')  . $image : "";
    }
    public function assign_facilities()
    {
        return $this->hasMany(AssignedOutdoorFacilities::class, 'facility_id', 'id');
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
        return HelperService::getTranslatedData($this, $this->name, 'name');
    }
}
