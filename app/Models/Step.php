<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;
    
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
