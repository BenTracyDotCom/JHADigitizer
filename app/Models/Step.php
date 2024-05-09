<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Step extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function jhas()
    {
      return $this->belongsTo(Jha::class);
    }
    
    public function hazards()
    {
      return $this->hasMany(Hazard::class);
    }

    protected $fillable = [
      'title'
    ];
}
