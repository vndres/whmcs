<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirigiendo a PayU...</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0f172a; color: white; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; font-family: sans-serif; }
        .loader { border: 4px solid #1e293b; border-top: 4px solid #10b981; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; margin-bottom: 20px; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>

    <div class="loader"></div>
    <h2 class="text-xl font-bold">Conectando con PayU Latam...</h2>
    <p class="text-slate-400 mt-2 text-sm">Por favor no cierres esta ventana.</p>

    {{-- FORMULARIO OCULTO QUE SE ENVÍA SOLO --}}
    <form id="payu_form" method="post" action="{{ $data['url'] }}">
        @foreach ($data as $key => $value)
            @if($key != 'url') {{-- La URL no es un campo del form, es el action --}}
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach
    </form>

    <script>
        // Auto-envío inmediato al cargar
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('payu_form').submit();
        });
    </script>

</body>
</html>