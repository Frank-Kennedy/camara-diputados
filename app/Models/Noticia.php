<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Noticia extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title_es',
        'title_fr',
        'title_pt',
        'title_en',
        'slug',
        'rol',
        'summary_es',
        'summary_fr',
        'summary_pt',
        'summary_en',
        'content_es',
        'content_fr',
        'content_pt',
        'content_en',
        'featured_image',
        'category',
        'published_date',
        'is_published',
        'is_featured',
        'views',
        'user_id',
        'tags',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_date' => 'date',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'views' => 'integer',
        'tags' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Los atributos que deben ser ocultos para las matrices.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    // ============================================
    // RELACIONES
    // ============================================

    /**
     * Obtener el usuario que creó esta noticia.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener las imágenes de la galería de esta noticia.
     */
    public function galeriaImagenes()
    {
        return $this->hasMany(GaleriaImagen::class)->orderBy('order');
    }

// Accesors para categoría
    public function getCategoryLabelAttribute()
    {
        $labels = [
            'institucional' => 'Institucional',
            'legislativo' => 'Legislativo',
            'eventos' => 'Eventos',
            'comunicados' => 'Comunicados',
            'internacional' => 'Internacional',
        ];
        return $labels[$this->category] ?? $this->category;
    }

    public function getStatusLabelAttribute()
    {
        return $this->is_published ? 'Publicada' : 'Borrador';
    }

    public function getStatusColorAttribute()
    {
        return $this->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
    }

    public function getCategoryColorAttribute()
    {
        $colors = [
            'institucional' => 'bg-blue-100 text-blue-800',
            'legislativo' => 'bg-purple-100 text-purple-800',
            'eventos' => 'bg-green-100 text-green-800',
            'comunicados' => 'bg-orange-100 text-orange-800',
            'internacional' => 'bg-teal-100 text-teal-800',
        ];
        return $colors[$this->category] ?? 'bg-gray-100 text-gray-800';
    }

    // ============================================
    // SCOPES (Consultas personalizadas)
    // ============================================

    /**
     * Scope para filtrar noticias publicadas.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope para filtrar noticias destacadas.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope para filtrar por categoría.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope para filtrar por búsqueda.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('title_es', 'like', "%{$search}%")
            ->orWhere('summary_es', 'like', "%{$search}%")
            ->orWhere('content_es', 'like', "%{$search}%");
    }

    /**
     * Scope para obtener noticias recientes.
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->published()
            ->orderBy('published_date', 'desc')
            ->limit($limit);
    }

    // ============================================
    // ACCESORS & MUTATORS
    // ============================================

    /**
     * Obtener el título en el idioma actual.
     */
    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        $field = 'title_' . $locale;
        return $this->$field ?? $this->title_es;
    }

    /**
     * Obtener el resumen en el idioma actual.
     */
    public function getSummaryAttribute()
    {
        $locale = app()->getLocale();
        $field = 'summary_' . $locale;
        return $this->$field ?? $this->summary_es;
    }

    /**
     * Obtener el contenido en el idioma actual.
     */
    public function getContentAttribute()
    {
        $locale = app()->getLocale();
        $field = 'content_' . $locale;
        return $this->$field ?? $this->content_es;
    }

    /**
     * Obtener la categoría traducida.
     */


    /**
     * Obtener el icono de la categoría.
     */
    public function getCategoryIconAttribute()
    {
        $icons = [
            'institucional' => 'fa-university',
            'legislativo' => 'fa-gavel',
            'eventos' => 'fa-calendar-alt',
            'comunicados' => 'fa-bullhorn',
            'internacional' => 'fa-globe',
        ];
        return $icons[$this->category] ?? 'fa-newspaper';
    }

 

    /**
     * Obtener la URL de la imagen destacada.
     */
    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return null;
    }

    /**
     * Obtener la URL de la imagen destacada con tamaño específico.
     */
    public function getFeaturedImageThumbAttribute()
    {
        if ($this->featured_image) {
            // Para usar con interven/image o similar
            return asset('storage/' . $this->featured_image);
        }
        return null;
    }

    /**
     * Obtener el extracto del contenido (primeros 150 caracteres).
     */
    public function getExcerptAttribute($length = 150)
    {
        return Str::limit(strip_tags($this->content_es), $length);
    }

    /**
     * Obtener el tiempo de lectura estimado.
     */
    public function getReadingTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content_es));
        $minutes = ceil($words / 200); // 200 palabras por minuto
        return $minutes . ' min' . ($minutes > 1 ? 's' : '');
    }


    /**
     * Obtener el enlace amigable (slug).
     */
    public function getLinkAttribute()
    {
        return route('noticias.show', $this->slug);
    }

    /**
     * Mutator para asegurar que el slug sea único.
     */
    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);
        $count = static::where('slug', $slug)->where('id', '!=', $this->id ?? 0)->count();
        
        if ($count > 0) {
            $slug = $slug . '-' . ($this->id ?? time());
        }
        
        $this->attributes['slug'] = $slug;
    }

    // ============================================
    // EVENTOS
    // ============================================

    /**
     * Boot del modelo.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($noticia) {
            if (empty($noticia->slug)) {
                $noticia->slug = Str::slug($noticia->title_es);
            }
        });
    }
}