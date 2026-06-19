@props([
    'name' => 'content',
    'value' => '',
    'id' => null,
    'height' => 500,
])

<textarea 
    id="{{ $id ?? $name }}" 
    name="{{ $name }}" 
    rows="10"
    {{ $attributes->merge(['class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul']) }}
>{{ $value }}</textarea>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editorId = '{{ $id ?? $name }}';
        const apiKey = '{{ env('TINYMCE_API_KEY') }}';
        
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#' + editorId,
                height: {{ $height }},
                menubar: true,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount',
                    'emoticons', 'template', 'paste', 'quickbars', 'noneditable'
                ],
                toolbar: 'undo redo | blocks | ' +
                    'bold italic underline strikethrough | ' +
                    'forecolor backcolor | alignleft aligncenter alignright alignjustify | ' +
                    'bullist numlist outdent indent | ' +
                    'link image media | ' +
                    'removeformat | fullscreen | help',
                toolbar_mode: 'sliding',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px; line-height:1.6; } ' +
                              'body { margin:16px; } ' +
                              'img { max-width:100%; height:auto; } ' +
                              'p { margin:0 0 1rem 0; } ' +
                              'h1, h2, h3 { color: #1a3a5c; }',
                branding: false,
                promotion: false,
                
                // Configuración para subir imágenes
                images_upload_url: '{{ route('admin.upload.image') }}',
                images_upload_credentials: true,
                automatic_uploads: true,
                file_picker_types: 'image',
                
                // Configuración de idioma (opcional)
                language: 'es',
                
                // Configuración de estilos
                formats: {
                    alignleft: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: { textAlign: 'left' } },
                    aligncenter: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: { textAlign: 'center' } },
                    alignright: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: { textAlign: 'right' } },
                    alignjustify: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: { textAlign: 'justify' } }
                },
                
                // Configuración de estilos de texto
                style_formats: [
                    { title: 'Párrafo', format: 'p' },
                    { title: 'Título 1', format: 'h1' },
                    { title: 'Título 2', format: 'h2' },
                    { title: 'Título 3', format: 'h3' },
                    { title: 'Título 4', format: 'h4' },
                    { title: 'Cita', format: 'blockquote' },
                    { title: 'Código', format: 'code' }
                ],
                
                // Configuración para guardar automáticamente
                autosave_ask_before_unload: true,
                autosave_interval: '30s',
                
                // Configuración de plantillas (opcional)
                templates: [
                    { title: 'Noticia estándar', description: 'Plantilla para noticias', content: '<h1>Título</h1><p>Contenido...</p>' }
                ],
                
                // Configuración de menú contextual
                contextmenu: 'link image table',
                
                // Configuración de atajos de teclado
                setup: function(editor) {
                    editor.on('change', function() {
                        editor.save();
                    });
                }
            });
        }
    });
</script>
@endpush