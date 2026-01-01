@extends('layouts.admin')
@section('title', 'Vincular WhatsApp')

@section('admin-content')
<div class="max-w-4xl mx-auto py-12 text-center">
    
    {{-- 1. MENSAJES DE ALERTA (Estilo Tailwind) --}}
    @if (session('success'))
        <div class="mb-6 mx-auto max-w-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl shadow-lg backdrop-blur-sm flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 mx-auto max-w-lg bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl shadow-lg backdrop-blur-sm flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- 2. HEADER --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Conectar Bot de WhatsApp</h1>
        <p class="text-slate-400 mt-2">Gestión de conexión y estados del sistema Linea365.</p>
    </div>
    
    {{-- 3. TARJETA PRINCIPAL (GLASSMORPHISM) --}}
    <div class="glass p-10 rounded-3xl inline-block border border-slate-800 bg-slate-900/50 shadow-2xl relative overflow-hidden transition-all duration-500 min-w-[350px]">
        
        {{-- Glow Effect --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-500"></div>

        {{-- LÓGICA DE ESTADOS BLADE --}}
        
        {{-- CASO A: QR LISTO PARA ESCANEAR --}}
        @if($status == 'QR_READY' && $qrCode)
            <div id="qr-container">
                <div class="mb-6">
                    <div class="relative flex h-4 w-4 mx-auto mb-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-4 w-4 bg-emerald-500"></span>
                    </div>
                    <p class="text-slate-300 text-sm font-medium animate-pulse">Código QR generado. Escanea ahora.</p>
                </div>
                
                {{-- Contenedor del QR --}}
                <div class="bg-white p-3 rounded-xl inline-block shadow-lg shadow-emerald-500/10 mb-4">
                    {{-- Aquí se dibuja el QR con JS --}}
                    <div id="qrcode"></div>
                </div>
                
                <div class="mt-4 text-left max-w-xs mx-auto bg-slate-800/50 p-4 rounded-xl border border-slate-700/50">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">Instrucciones:</p>
                    <ol class="text-xs text-slate-300 list-decimal list-inside space-y-1">
                        <li>Abre WhatsApp en tu celular.</li>
                        <li>Ve a <strong>Dispositivos vinculados</strong>.</li>
                        <li>Escanea este código.</li>
                    </ol>
                </div>

                {{-- Auto-recarga para detectar cuando se conecte --}}
                <p class="text-xs text-slate-500 mt-4">Actualizando estado en 10s...</p>
                <script>
                    setTimeout(function(){ location.reload(); }, 10000);
                </script>
            </div>

            {{-- Script para pintar el QR --}}
            <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
            <script type="text/javascript">
                new QRCode(document.getElementById("qrcode"), {
                    text: "{{ $qrCode }}",
                    width: 250,
                    height: 250
                });
            </script>

        {{-- CASO B: CONECTADO (READY) --}}
        @elseif($status == 'READY')
            <div id="connected-container" class="py-2">
                <div class="flex justify-center mb-6">
                    <div class="rounded-full bg-emerald-500/10 p-6 border border-emerald-500/30 shadow-[0_0_30px_rgba(16,185,129,0.2)]">
                        <svg class="w-16 h-16 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">¡WhatsApp Conectado!</h2>
                <p class="text-slate-400 mb-6">El bot está activo y escuchando.</p>
                
                <div class="flex items-center justify-center gap-2 mb-8">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    <span class="text-xs text-emerald-500 font-mono font-bold tracking-wider">ONLINE</span>
                </div>

                <div class="grid grid-cols-1 gap-3 max-w-xs mx-auto">
                    {{-- Botón Modal Prueba --}}
                    <button type="button" onclick="toggleModal('testModal')" class="w-full py-3 px-4 bg-slate-700/50 hover:bg-slate-700 text-white rounded-xl font-medium transition-colors border border-slate-600 flex items-center justify-center gap-2">
                        <span>📩</span> Enviar Prueba
                    </button>

                    {{-- Formulario Logout --}}
                    <form action="{{ route('admin.whatsapp.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3 px-4 bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 rounded-xl font-medium transition-colors border border-red-500/30 flex items-center justify-center gap-2">
                            <span>🔌</span> Desconectar
                        </button>
                    </form>
                </div>
            </div>

        {{-- CASO C: DESCONECTADO O ERROR --}}
        @else
            <div class="py-8">
                <div class="flex justify-center mb-6">
                    <div class="rounded-full bg-red-500/10 p-6 border border-red-500/30">
                        <svg class="w-16 h-16 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">Bot Desconectado</h2>
                <p class="text-slate-400 mb-6">El servicio de Node.js parece estar apagado o reiniciándose.</p>
                
                <a href="{{ route('admin.whatsapp.index') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Reintentar Conexión
                </a>
            </div>
        @endif

    </div>
</div>

{{-- 4. MODAL DE PRUEBA (DISEÑO TAILWIND) --}}
<div id="testModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    {{-- Backdrop oscuro --}}
    <div class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm transition-opacity" onclick="toggleModal('testModal')"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-slate-800 border border-slate-700 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                
                <form action="{{ route('admin.whatsapp.test') }}" method="POST">
                    @csrf
                    <div class="px-6 py-6">
                        <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <span>🚀</span> Enviar Mensaje de Prueba
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Número de Celular</label>
                                <input type="text" name="phone" placeholder="Ej: 573001234567" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none placeholder-slate-600" required>
                                <p class="text-xs text-slate-500 mt-1">Incluye el código de país sin el símbolo +</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Mensaje</label>
                                <textarea name="message" rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none" required>Hola, prueba de conexión desde Linea365.</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-slate-900/50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-700">
                        <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-emerald-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none sm:w-auto">
                            Enviar
                        </button>
                        <button type="button" onclick="toggleModal('testModal')" class="inline-flex w-full justify-center rounded-lg border border-slate-600 bg-transparent px-4 py-2 text-base font-medium text-slate-300 shadow-sm hover:bg-slate-700 focus:outline-none sm:w-auto">
                            Cancelar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

{{-- SCRIPT PARA CONTROLAR EL MODAL --}}
<script>
    function toggleModal(modalID){
        document.getElementById(modalID).classList.toggle("hidden");
    }
</script>
@endsection