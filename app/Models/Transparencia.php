<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transparencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transparencia';

    protected $fillable = [
        'title_es',
        'title_fr',
        'title_pt',
        'title_en',
        'category',
        'year',
        'file_pdf',
        'file_excel',
        'description_es',
        'description_fr',
        'description_pt',
        'description_en',
        'publication_date',
        'is_public',
        'downloads',
    ];

    protected $casts = [
        'year' => 'integer',
        'publication_date' => 'date',
        'is_public' => 'boolean',
        'downloads' => 'integer',
    ];

    // ============================================
    // ACCESORS
    // ============================================

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        $field = 'title_' . $locale;
        return $this->$field ?? $this->title_es;
    }

    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        $field = 'description_' . $locale;
        return $this->$field ?? $this->description_es;
    }

    public function getCategoryLabelAttribute()
    {
        $labels = [
            'presupuesto' => '💰 Presupuesto',
            'informe_gestion' => '📊 Informe de Gestión',
            'rendicion_cuentas' => '⚖️ Rendición de Cuentas',
            'contrataciones' => '📄 Contrataciones',
            'planificacion' => '📅 Planificación',
        ];
        return $labels[$this->category] ?? $this->category;
    }

    public function getCategoryIconAttribute()
    {
        $icons = [
            'presupuesto' => 'fa-coins',
            'informe_gestion' => 'fa-chart-bar',
            'rendicion_cuentas' => 'fa-balance-scale',
            'contrataciones' => 'fa-file-signature',
            'planificacion' => 'fa-calendar-check',
        ];
        return $icons[$this->category] ?? 'fa-file';
    }

    public function getCategoryColorAttribute()
    {
        $colors = [
            'presupuesto' => 'bg-green-100 text-green-800',
            'informe_gestion' => 'bg-blue-100 text-blue-800',
            'rendicion_cuentas' => 'bg-purple-100 text-purple-800',
            'contrataciones' => 'bg-orange-100 text-orange-800',
            'planificacion' => 'bg-teal-100 text-teal-800',
        ];
        return $colors[$this->category] ?? 'bg-gray-100 text-gray-800';
    }

    public function getPdfUrlAttribute()
    {
        if ($this->file_pdf) {
            return asset('storage/' . $this->file_pdf);
        }
        return null;
    }

    public function getExcelUrlAttribute()
    {
        if ($this->file_excel) {
            return asset('storage/' . $this->file_excel);
        }
        return null;
    }

    public function getHasPdfAttribute()
    {
        return !is_null($this->file_pdf);
    }

    public function getHasExcelAttribute()
    {
        return !is_null($this->file_excel);
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title_es', 'like', "%{$search}%")
            ->orWhere('description_es', 'like', "%{$search}%");
    }
}