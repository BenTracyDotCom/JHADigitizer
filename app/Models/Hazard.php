<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hazard extends Model
{
  use HasFactory;
  use SoftDeletes;

  public function steps()
  {
    return $this->belongsTo(Step::class);
  }

  public function controls()
  {
    return $this->hasMany(Control::class);
  }

  protected $fillable = [
    'title'
  ];
}
