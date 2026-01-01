@extends('layouts.frontend')

@section('title', 'Mis Facturas')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Historial de Facturación</h1>
            <p class="text-slate-400 text-sm">Gestiona tus pagos y descarga comprobantes.</p>
        </div>
        
        @if(isset($client))
        <div class="hidden sm:block text-right">
            <div class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Estado de Cuenta</div>
            <div class="text-emerald-400 font-bold text-sm">Activo</div>
        </div>
        @endif
    </div>

    {{-- Caso Vacío --}}
    @if(!isset($client) || $invoices->isEmpty())
        <div class="glass p-12 rounded-2xl border border-slate-800 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-800/50 text-4xl mb-4 grayscale opacity-50">
                🧾
            </div>
            <h3 class="text-lg font-bold text-white">No tienes facturas generadas</h3>
            <p class="text-slate-400 mt-2 text-sm max-w-md mx-auto">
                Las facturas aparecerán aquí automáticamente cuando contrates un servicio.
            </p>
            <a href="{{ route('store.index') }}" class="mt-8 inline-block bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-lg shadow-emerald-900/20">
                Ver Servicios
            </a>
        </div>
    @else
        {{-- Tabla de Facturas --}}
        <div class="glass rounded-2xl border border-slate-800 overflow-hidden shadow-2xl shadow-black/20">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-400">
                    <thead class="bg-slate-900/90 text-slate-300 uppercase text-[10px] font-bold tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="px-6 py-4">N° Factura</th>
                            <th class="px-6 py-4">Emisión</th>
                            <th class="px-6 py-4">Vencimiento</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4 text-center">Estado</th>
                            <th class="px-6 py-4 text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/50">
                        @foreach($invoices as $invoice)
                        <tr class="hover:bg-slate-800/40 transition group">
                            {{-- Número --}}
                            <td class="px-6 py-4 font-mono font-medium text-white group-hover:text-emerald-400 transition">
                                {{ $invoice->number }}
                            </td>
                            
                            {{-- Fechas --}}
                            <td class="px-6 py-4">
                                {{ $invoice->issue_date ? \Carbon\Carbon::parse($invoice->issue_date)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') : '-' }}
                            </td>

                            {{-- Total --}}
                            <td class="px-6 py-4 font-bold text-slate-200">
                                {{ $invoice->currency }} {{ number_format($invoice->total, 2) }}
                            </td>

                            {{-- Estado (Badge) --}}
                            <td class="px-6 py-4 text-center">
                                @if($invoice->status == 'paid')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        PAGADA
                                    </span>
                                @elseif($invoice->status == 'unpaid')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                        PENDIENTE
                                    </span>
                                @elseif($invoice->status == 'overdue')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                        VENCIDA
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-700 text-slate-400">
                                        {{ strtoupper($invoice->status) }}
                                    </span>
                                @endif
                            </td>

                            {{-- Botones --}}
                            <td class="px-6 py-4 text-right">
                                @if($invoice->status == 'unpaid' || $invoice->status == 'overdue')
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-lg shadow-emerald-900/20 transform hover:scale-105">
                                        Pagar
                                    </a>
                                @else
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="inline-flex items-center gap-1 border border-slate-700 hover:bg-slate-800 text-slate-300 hover:text-white text-xs font-medium px-4 py-2 rounded-lg transition">
                                        Ver Detalle
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($invoices->hasPages())
                <div class="px-6 py-4 border-t border-slate-800">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
@endsection