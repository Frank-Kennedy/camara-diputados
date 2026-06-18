<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultaCiudadana extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'consultas_ciudadanas';

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'subject_es',
        'subject_fr',
        'subject_pt',
        'subject_en',
        'type',
        'message_es',
        'message_fr',
        'message_pt',
        'message_en',
        'file_attachment',
        'status',
        'response_es',
        'response_fr',
        'response_pt',
        'response_en',
        'user_id',
        'response_date',
        'is_public',
        'is_anonymous',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_anonymous' => 'boolean',
        'response_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accesors
    public function getTypeLabelAttribute()
    {
        $labels = [
            'sugerencia' => 'Sugerencia',
            'consulta' => 'Consulta',
            'queja' => 'Queja',
            'solicitud' => 'Solicitud',
            'denuncia' => 'Denuncia',
        ];
        return $labels[$this->type] ?? $this->type;
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pendiente' => 'Pendiente',
            'en_proceso' => 'En Proceso',
            'resuelta' => 'Resuelta',
            'archivada' => 'Archivada',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pendiente' => 'bg-yellow-100 text-yellow-800',
            'en_proceso' => 'bg-blue-100 text-blue-800',
            'resuelta' => 'bg-green-100 text-green-800',
            'archivada' => 'bg-gray-100 text-gray-800',
        ];
        return $colors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getSubjectAttribute()
    {
        $locale = app()->getLocale();
        $field = 'subject_' . $locale;
        return $this->$field ?? $this->subject_es;
    }

    public function getMessageAttribute()
    {
        $locale = app()->getLocale();
        $field = 'message_' . $locale;
        return $this->$field ?? $this->message_es;
    }

    public function getResponseAttribute()
    {
        $locale = app()->getLocale();
        $field = 'response_' . $locale;
        return $this->$field ?? $this->response_es;
    }

    public function getFileUrlAttribute()
    {
        if ($this->file_attachment) {
            return asset('storage/' . $this->file_attachment);
        }
        return null;
    }

    public function getFullNameAttribute()
    {
        if ($this->is_anonymous) {
            return 'Anónimo';
        }
        return $this->name . ' ' . $this->last_name;
    }
}