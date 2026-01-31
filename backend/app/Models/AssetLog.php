<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetLog extends Model
{
    use HasFactory;
    protected $fillable = ['asset_id', 'description', 'changes'];
    protected $casts = [
        'changes' => 'array',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
