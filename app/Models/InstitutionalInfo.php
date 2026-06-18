<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionalInfo extends Model
{
    use HasFactory;
    protected $table = 'institutional_info';
    protected $fillable = [
        'section',
        'title_es',
        'title_fr',
        'title_pt',
        'title_en',
        'content_es',
        'content_fr',
        'content_pt',
        'content_en',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        $field = 'title_' . $locale;
        return $this->$field ?? $this->title_es;
    }

    public function getContentAttribute()
    {
        $locale = app()->getLocale();
        $field = 'content_' . $locale;
        return $this->$field ?? $this->content_es;
    }
}