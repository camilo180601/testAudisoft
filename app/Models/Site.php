<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Site extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'category_id'];

    /**
     * Categoría a la que pertenece el sitio.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Host legible de la URL (p. ej. "www.zara.com"), para mostrar en la tabla.
     */
    public function getHostAttribute(): string
    {
        return parse_url($this->url, PHP_URL_HOST) ?: $this->url;
    }
}
