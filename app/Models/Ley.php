<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ley extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Especificar el nombre de la tabla.
     * IMPORTANTE: Laravel pluraliza "ley" como "leys", pero la tabla se llama "leyes"
     */
    protected $table = 'leyes';

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
        'code',
        'category',
        'type',
        'status',
        'role',
        'summary_es',
        'summary_fr',
        'summary_pt',
        'summary_en',
        'content_es',
        'content_fr',
        'content_pt',
        'content_en',
        'presentation_date',
        'approval_date',
        'file_pdf',
        'diputado_id',
        'comision_id',
        'views',
        'downloads',
        'is_public',
        'is_featured',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'presentation_date' => 'date',
        'approval_date' => 'date',
        'views' => 'integer',
        'downloads' => 'integer',
        'is_public' => 'boolean',
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
     * Obtener el diputado que presentó esta ley.
     */
    public function diputado()
    {
        return $this->belongsTo(Diputado::class);
    }

    /**
     * Obtener la comisión que revisa esta ley.
     */
    public function comision()
    {
        return $this->belongsTo(Comision::class);
    }

    // ============================================
    // SCOPES (Consultas personalizadas)
    // ============================================

    /**
     * Scope para filtrar leyes públicas.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope para filtrar por tipo.
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope para filtrar por estado.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope para filtrar por año.
     */
    public function scopeYear($query, $year)
    {
        return $query->whereYear('presentation_date', $year);
    }

    /**
     * Scope para filtrar por búsqueda.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('title_es', 'like', "%{$search}%")
            ->orWhere('code', 'like', "%{$search}%")
            ->orWhere('summary_es', 'like', "%{$search}%");
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
     * Obtener el estado traducido.
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'propuesta' => 'Propuesta',
            'en_discusion' => 'En Discusión',
            'aprobada' => 'Aprobada',
            'rechazada' => 'Rechazada',
            'archivada' => 'Archivada',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Obtener el tipo traducido.
     */
    public function getTypeLabelAttribute()
    {
        $labels = [
            'ley' => 'Ley',
            'proyecto' => 'Proyecto de Ley',
            'resolucion' => 'Resolución',
            'decreto' => 'Decreto',
        ];
        return $labels[$this->type] ?? $this->type;
    }

    /**
     * Obtener el color del estado para badges.
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'propuesta' => 'bg-yellow-100 text-yellow-800',
            'en_discusion' => 'bg-blue-100 text-blue-800',
            'aprobada' => 'bg-green-100 text-green-800',
            'rechazada' => 'bg-red-100 text-red-800',
            'archivada' => 'bg-gray-100 text-gray-800',
        ];
        return $colors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Obtener la URL del archivo PDF.
     */
    public function getPdfUrlAttribute()
    {
        if ($this->file_pdf) {
            return asset('storage/' . $this->file_pdf);
        }
        return null;
    }

    /**
     * Obtener el código completo con año.
     */
    public function getFullCodeAttribute()
    {
        $year = $this->presentation_date ? date('Y', strtotime($this->presentation_date)) : date('Y');
        return $this->code . ' (' . $year . ')';
    }
}