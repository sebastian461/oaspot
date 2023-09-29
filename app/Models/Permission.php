<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
  use HasFactory;

  protected $guarded = [];

  public function role_has_permission(): HasMany
  {
    return $this->hasMany(RoleHasPermission::class);
  }
}
