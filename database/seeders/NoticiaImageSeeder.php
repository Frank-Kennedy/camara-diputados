<?php

namespace Database\Seeders;

use App\Models\Noticia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class NoticiaImageSeeder extends Seeder
{
    public function run()
    {
        $noticias = Noticia::all();
        
        $imagenes = [
            'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?w=800',
            'https://images.unsplash.com/photo-1582555172866-f73bb0ffb2dd?w=800',
            'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=800',
            'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=800',
            'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800',
        ];
        
        foreach ($noticias as $index => $noticia) {
            $imgIndex = $index % count($imagenes);
            try {
                $contents = file_get_contents($imagenes[$imgIndex]);
                $filename = 'noticias/' . $noticia->id . '.jpg';
                Storage::disk('public')->put($filename, $contents);
                $noticia->update(['featured_image' => $filename]);
                echo "✓ Imagen agregada a: " . $noticia->title_es . "\n";
            } catch (\Exception $e) {
                echo "✗ Error con: " . $noticia->title_es . "\n";
            }
        }
    }
}