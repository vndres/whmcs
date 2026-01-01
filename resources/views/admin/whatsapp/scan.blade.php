@extends('layouts.admin')
@section('title', 'Vincular WhatsApp')

@section('admin-content')
<div class="max-w-4xl mx-auto py-12 text-center">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Conectar Bot de WhatsApp</h1>
        <p class="text-slate-400 mt-2">Escanea el código QR para activar las notificaciones automáticas.</p>
    </div>
    
    <div class="glass p-10 rounded-3xl inline-block border border-slate-800 bg-slate-900/50 shadow-2xl relative overflow-hidden">
        
        {{-- Efecto de fondo (Glow) --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-500"></div>

        {{-- CONTENEDOR DEL QR --}}
        <div id="qr-container">
            <div class="mb-6">
                <div class="relative flex h-4 w-4 mx-auto mb-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-4 w-4 bg-emerald-500"></span>
                </div>
                <p id="status-text" class="text-slate-300 text-sm font-medium animate-pulse">Esperando conexión con el servidor...</p>
            </div>
            
            {{-- Imagen del QR (Se muestra cuando llega el evento) --}}
            <div class="bg-white p-2 rounded-xl inline-block">
                <img id="qr-image" src="" class="hidden border-2 border-slate-100 rounded-lg" width="280" height="280" alt="Código QR">
                {{-- Placeholder mientras carga --}}
                <div id="qr-placeholder" class="w-[280px] h-[280px] bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                    <svg class="w-12 h-12 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            </div>
            
            <div class="mt-6 text-left max-w-xs mx-auto bg-slate-800/50 p-4 rounded-xl border border-slate-700/50">
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">Instrucciones:</p>
                <ol class="text-xs text-slate-300 list-decimal list-inside space-y-1">
                    <li>Abre WhatsApp en tu celular.</li>
                    <li>Ve a <strong>Menú</strong> (o Configuración).</li>
                    <li>Selecciona <strong>Dispositivos vinculados</strong>.</li>
                    <li>Toca en <strong>Vincular dispositivo</strong>.</li>
                </ol>
            </div>
        </div>

        {{-- CONTENEDOR DE ÉXITO (Oculto por defecto) --}}
        <div id="connected-container" class="hidden py-8">
            <div class="flex justify-center mb-6">
                <div class="rounded-full bg-emerald-500/10 p-6 border border-emerald-500/30 shadow-[0_0_30px_rgba(16,185,129,0.2)]">
                    <svg class="w-16 h-16 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-white mb-3">¡WhatsApp Conectado!</h2>
            <p class="text-slate-400 mb-6">El bot está activo y listo para enviar notificaciones.</p>
            
            <div class="text-xs text-emerald-500 bg-emerald-500/10 border border-emerald-500/20 px-4 py-2 rounded-lg inline-block font-mono">
                Estado: ONLINE
            </div>
        </div>

    </div>
</div>

{{-- Cliente Socket.IO (CDN) --}}
<script src="https://cdn.socket.io/4.7.4/socket.io.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const qrImage = document.getElementById('qr-image');
        const qrPlaceholder = document.getElementById('qr-placeholder');
        const qrContainer = document.getElementById('qr-container');
        const connectedContainer = document.getElementById('connected-container');
        const statusText = document.getElementById('status-text');

        // 1. CONEXIÓN AL BOT (SUBDOMINIO HTTPS)
        // 'transports: polling' es vital para CloudLinux/cPanel
        const socket = io('https://bot.linea365apps.com', {
            transports: ['polling'],
            secure: true,
            reconnection: true,
            reconnectionAttempts: 5
        });

        // EVENTO: Conectado al servidor Node
        socket.on('connect', () => {
            console.log('Socket conectado. Esperando QR...');
            statusText.innerText = 'Generando código QR...';
        });

        // EVENTO: Recibir Código QR
        socket.on('qr', (qrCode) => {
            console.log('QR Recibido');
            statusText.innerText = 'Escanea el código ahora';
            
            // Usamos API rápida para renderizar el QR
            qrImage.src = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodeURIComponent(qrCode)}`;
            
            // Mostrar imagen cuando cargue
            qrImage.onload = function() {
                qrPlaceholder.classList.add('hidden');
                qrImage.classList.remove('hidden');
            };

            // Asegurar que estamos en la pantalla de QR
            qrContainer.classList.remove('hidden');
            connectedContainer.classList.add('hidden');
        });

        // EVENTO: WhatsApp Listo (Ya escaneado o sesión restaurada)
        socket.on('ready', (msg) => {
            console.log('Sesión WhatsApp Lista');
            qrContainer.classList.add('hidden');
            connectedContainer.classList.remove('hidden');
        });

        // Manejo de desconexión
        socket.on('disconnect', () => {
            console.log('Socket desconectado');
            statusText.innerText = 'Desconectado. Reintentando...';
        });
    });
</script>
@endsection