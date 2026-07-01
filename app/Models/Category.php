<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Sitios que pertenecen a esta categoría.
     */
    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }

    /**
     * ¿La categoría está en uso por algún sitio?
     */
    public function isInUse(): bool
    {
        return $this->sites()->exists();
    }
}
