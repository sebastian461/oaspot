<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleHasPermission extends Model
{
  use HasFactory;

  protected $primaryKey = 'permission_id';

  public $incrementing = false;

  protected $fillable = [
    'permission_id',
    'role_id'
  ];

  public $timestamps = false;

  public function role(): BelongsTo
  {
    return $this->belongsTo(Role::class);
  }

  public function permission(): BelongsTo
  {
    return $this->belongsTo(Permission::class);
  }
}
