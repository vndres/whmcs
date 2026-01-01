@extends('layouts.frontend')

@section('title', 'Pagar Factura #' . $invoice->id)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-white">Finalizar Pago</h1>
        <p class="text-slate-400 mt-2">Selecciona un método de pago seguro para activar tu servicio.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        
        {{-- COLUMNA IZQUIERDA: RESUMEN FACTURA --}}
        <div class="md:col-span-1">
            <div class="glass rounded-2xl p-6 border border-slate-700 sticky top-24">
                <h3 class="text-sm uppercase tracking-wider text-slate-500 font-bold mb-4">Resumen de Orden</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-300">Factura #:</span>
                        <span class="font-mono text-white">{{ $invoice->id }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-300">Fecha Emisión:</span>
                        <span class="text-white">{{ $invoice->issue_date->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-300">Estado:</span>
                        <span class="px-2 py-0.5 rounded text-xs font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30">
                            Pendiente
                        </span>
                    </div>
                    
                    <hr class="border-slate-700 my-4">
                    
                    <div class="flex justify-between items-end">
                        <span class="text-slate-300 font-bold">Total a Pagar:</span>
                        <span class="text-3xl font-bold text-emerald-400">
                            ${{ number_format($invoice->total, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: MÉTODOS DE PAGO --}}
        <div class="md:col-span-2 space-y-6">
            
            @if(session('error'))
                <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-xl flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-bold">Error en el pago</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <h3 class="text-lg font-bold text-white mb-4">Elige cómo quieres pagar:</h3>

            <div class="grid gap-4">
                @foreach($gateways as $gateway)
                    <form action="{{ route('payment.process', $invoice->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="gateway" value="{{ $gateway->slug }}">
                        
                        <button type="submit" class="w-full group relative flex items-center p-5 rounded-xl border border-slate-700 bg-slate-800/50 hover:bg-slate-800 hover:border-emerald-500/50 transition-all duration-300 text-left">
                            
                            {{-- Icono Pasarela (Puedes personalizar según el slug) --}}
                            <div class="h-12 w-12 rounded-full bg-slate-700 flex items-center justify-center mr-5 group-hover:bg-emerald-500/20 group-hover:text-emerald-400 transition-colors">
                                @if($gateway->slug == 'paypal')
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M7.076 21.337l.756-4.728H9.37a22.25 22.25 0 001.378-5.32c.213-2.02 1.39-2.613 2.92-2.613h.363c1.55 0 2.597.567 2.822 2.37.15.93.04 1.95-.316 2.86-.67 1.83-2.27 3.32-4.52 3.32H10.56l-.82 5.11H7.076zm-3.04 0l2.316-14.73C6.67 4.95 8.16 3.9 10.3 3.9h1.79c3.96 0 5.69 2.05 5.09 5.86-.54 3.49-3.23 6.96-7.39 6.96h-1.25L7.4 21.337H4.036z"/></svg>
                                @elseif($gateway->slug == 'payu')
                                    <span class="text-xl font-bold">P</span>
                                @else
                                    <span class="text-xl">💳</span>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h4 class="text-lg font-bold text-white group-hover:text-emerald-400 transition-colors">
                                    {{ $gateway->name }}
                                </h4>
                                <p class="text-sm text-slate-400">
                                    @if($gateway->slug == 'paypal')
                                        Pagar con Saldo PayPal o Tarjeta Internacional.
                                    @elseif($gateway->slug == 'payu')
                                        Tarjetas Débito/Crédito, PSE, Nequi y Efecty.
                                    @else
                                        Procesamiento seguro.
                                    @endif
                                </p>
                            </div>

                            <div class="text-slate-500 group-hover:text-emerald-400 group-hover:translate-x-1 transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </button>
                    </form>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <p class="text-xs text-slate-500 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Pagos cifrados con seguridad SSL de 256-bits.
                </p>
            </div>

        </div>
    </div>
</div>
@endsection