<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['category_id', 'location_id', 'name', 'code', 'status'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($asset) {
            $asset->logs()->delete();
        });
    }

    public function logs()
    {
        return $this->hasMany(AssetLog::class);
    }

    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
