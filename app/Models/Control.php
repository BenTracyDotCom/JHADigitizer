<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    use HasFactory;

    public function hazards()
    {
      return $this->belongsTo(Control::class);
    }

    protected $fillable = [
      'title'
    ];
}
