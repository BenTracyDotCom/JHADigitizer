<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hazard extends Model
{
    use HasFactory;

    public function steps()
    {
      return $this->belongsTo(Step::class);
    }

    public function controls()
    {
      return $this->hasMany(Control::class);
    }
}
