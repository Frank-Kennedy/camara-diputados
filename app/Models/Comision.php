<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comision extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comisiones';

    protected $fillable = [
        'name_es',
        'name_fr',
        'name_pt',
        'name_en',
        'description_es',
        'description_fr',
        'description_pt',
        'description_en',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relación con diputados
    public function diputados()
    {
        return $this->belongsToMany(
            Diputado::class,
            'diputado_comision',
            'comision_id',
            'diputado_id'
        )->withPivot('role')
         ->withTimestamps();
    }

    public function leyes()
    {
        return $this->hasMany(Ley::class);
    }

    // Accesors
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        $field = 'name_' . $locale;
        return $this->$field ?? $this->name_es;
    }

    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        $field = 'description_' . $locale;
        return $this->$field ?? $this->description_es;
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    public function getDiputadosCountAttribute()
    {
        return $this->diputados()->where('is_active', true)->count();
    }
}