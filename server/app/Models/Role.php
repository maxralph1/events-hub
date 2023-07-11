<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    // const SUPERADMIN_ROLE = 1;
    // const ADMIN_ROLE = 2;
    // const USER_ROLE = 3;

    use HasFactory, HasUlids;

    protected $fillable = ['title'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
