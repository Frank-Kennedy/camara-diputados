<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diputado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'diputados';

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'photo',
        'rol',
        'political_party',
        'constituency',
        'position',
        'biography_es',
        'biography_fr',
        'biography_pt',
        'biography_en',
        'social_networks',
        'start_date',
        'end_date',
        'is_active',
        'views',
    ];

    protected $casts = [
        'social_networks' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'views' => 'integer',
    ];

    // Relaciones
    public function comisiones()
    {
        return $this->belongsToMany(Comision::class, 'diputado_comision', 'diputado_id', 'comision_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function leyes()
    {
        return $this->hasMany(Ley::class);
    }

    // Accesors
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }

    public function getBiographyAttribute()
    {
        $locale = app()->getLocale();
        $field = 'biography_' . $locale;
        return $this->$field ?? $this->biography_es;
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return null;
    }

    public function getStatusBadgeAttribute()
    {
        return $this->is_active 
            ? '<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Activo</span>'
            : '<span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Inactivo</span>';
    }
}