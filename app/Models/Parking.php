<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parking extends Model
{
  use HasFactory;

  protected $attributes = [
    'status' => 'pending',
  ];

  protected $fillable = [
    'user_id',
    'name',
    'city_id',
    'address',
    'places',
    'price',
    'description',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function city(): BelongsTo
  {
    return $this->belongsTo(City::class);
  }

  public function document(): HasMany
  {
    return $this->hasMany(Document::class);
  }

  public function image(): HasMany
  {
    return $this->hasMany(Image::class);
  }
}
