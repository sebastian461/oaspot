<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
  use HasFactory;

  protected $guarded = [];

  public function role_has_permissions(): HasMany
  {
    return $this->hasMany(RoleHasPermission::class);
  }
}
