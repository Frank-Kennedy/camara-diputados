<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriaImagen extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'caption_es',
        'caption_fr',
        'caption_pt',
        'caption_en',
        'noticia_id',
        'order',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================
    // RELACIONES
    // ============================================

    /**
     * Obtener la noticia a la que pertenece esta imagen.
     */
    public function noticia()
    {
        return $this->belongsTo(Noticia::class);
    }

    // ============================================
    // ACCESORS & MUTATORS
    // ============================================

    /**
     * Obtener el título en el idioma actual.
     */
    public function getCaptionAttribute()
    {
        $locale = app()->getLocale();
        $field = 'caption_' . $locale;
        return $this->$field ?? $this->caption_es;
    }

    /**
     * Obtener la URL de la imagen.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Obtener el nombre del archivo de la imagen.
     */
    public function getImageNameAttribute()
    {
        if ($this->image) {
            return basename($this->image);
        }
        return null;
    }
}