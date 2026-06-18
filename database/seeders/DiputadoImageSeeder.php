<?php

namespace Database\Seeders;

use App\Models\Diputado;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DiputadoImageSeeder extends Seeder
{
    public function run()
    {
        $diputados = Diputado::all();
        
        // URLs de imágenes de ejemplo (personas)
        $fotos = [
            'https://randomuser.me/api/portraits/men/1.jpg',
            'https://randomuser.me/api/portraits/women/1.jpg',
            'https://randomuser.me/api/portraits/men/2.jpg',
            'https://randomuser.me/api/portraits/women/2.jpg',
            'https://randomuser.me/api/portraits/men/3.jpg',
        ];
        
        foreach ($diputados as $index => $diputado) {
            $fotoIndex = $index % count($fotos);
            try {
                $contents = file_get_contents($fotos[$fotoIndex]);
                $filename = 'diputados/' . $diputado->id . '.jpg';
                Storage::disk('public')->put($filename, $contents);
                $diputado->update(['photo' => $filename]);
                echo "✓ Foto agregada a: " . $diputado->full_name . "\n";
            } catch (\Exception $e) {
                echo "✗ Error con: " . $diputado->full_name . "\n";
            }
        }
    }
}