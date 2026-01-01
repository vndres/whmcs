@extends('layouts.frontend')

@section('title', 'Factura #' . $invoice->number)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    {{-- BARRA DE ACCIONES (Visible solo en pantalla, oculta al imprimir) --}}
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-8 no-print">
        <div>
            <a href="{{ route('invoices.index') }}" class="text-sm text-slate-400 hover:text-white transition flex items-center gap-2 mb-1 group">
                <span class="group-hover:-translate-x-1 transition">&larr;</span> Volver al historial
            </a>
            <h1 class="text-xl font-bold text-white">Detalle de Factura #{{ $invoice->number }}</h1>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl hover:bg-slate-700 hover:text-white transition flex items-center gap-2 text-sm font-medium border border-slate-700">
                🖨️ Imprimir / PDF
            </button>
            
            @if($invoice->status == 'unpaid' || $invoice->status == 'overdue')
                <a href="{{ route('payment.show', $invoice->id) }}" class="px-6 py-2 bg-emerald-500 text-slate-900 font-bold rounded-xl hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20 text-sm flex items-center gap-2 animate-pulse">
                    <span>💳</span> Pagar Ahora
                </a>
            @endif
        </div>
    </div>

    {{-- PAPEL DE FACTURA (Diseño Profesional para Impresión) --}}
    <div class="invoice-paper bg-white text-slate-900 rounded-xl overflow-hidden shadow-2xl relative">
        
        {{-- Sellos de Agua --}}
        @if($invoice->status == 'paid')
            <div class="absolute top-12 right-12 border-[5px] border-emerald-600 text-emerald-600 px-6 py-2 text-2xl font-black uppercase transform -rotate-12 opacity-30 select-none pointer-events-none">
                PAGADA
            </div>
        @elseif($invoice->status == 'cancelled')
            <div class="absolute top-12 right-12 border-[5px] border-slate-400 text-slate-400 px-6 py-2 text-2xl font-black uppercase transform -rotate-12 opacity-30 select-none pointer-events-none">
                ANULADA
            </div>
        @endif

        {{-- 1. CABECERA --}}
        <div class="p-10 md:p-12 border-b border-slate-100 bg-slate-50/50">
            <div class="flex justify-between items-start">
                <div>
                    {{-- Logo Corporativo --}}
                    <div class="flex items-center gap-2 mb-4">
                        <div class="h-10 w-10 bg-slate-900 rounded-lg flex items-center justify-center text-white font-bold text-xl">L</div>
                        <span class="text-3xl font-bold text-slate-900 tracking-tight">Linea365</span>
                    </div>
                    <div class="text-sm text-slate-500 leading-relaxed font-medium">
                        Hosting, Dominios & Cloud Services<br>
                        NIT: 900.123.456-1<br>
                        Calle 123 #45-67, Edificio Tech<br>
                        Bogotá, Colombia<br>
                        <span class="text-slate-400">soporte@linea365.com</span>
                    </div>
                </div>
                <div class="text-right">
                    <h2 class="text-4xl font-light text-slate-300 uppercase tracking-widest">Factura</h2>
                    <p class="text-xl font-bold text-slate-800 mt-1">{{ $invoice->number }}</p>
                    <p class="text-xs text-slate-400 mt-1 font-mono">REF: {{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>

        {{-- 2. DATOS DEL CLIENTE --}}
        <div class="p-10 md:p-12 grid md:grid-cols-2 gap-10">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Facturado a:</h3>
                
                <div class="text-slate-900 font-bold text-xl">{{ $client->first_name }} {{ $client->last_name }}</div>
                
                @if($client->company_name)
                    <div class="text-slate-600 font-medium text-base mb-1">{{ $client->company_name }}</div>
                @endif
                
                <div class="text-slate-500 text-sm mt-3 leading-relaxed border-l-2 border-slate-200 pl-3">
                    {{ $client->email }}<br>
                    {{ $client->address ?? 'Dirección no registrada' }}<br>
                    {{ $client->city }} {{ $client->country }}<br>
                    @if($client->phone) Tel: {{ $client->phone }} @endif
                </div>
            </div>
            
            <div class="md:text-right space-y-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Fecha de Emisión</span>
                    <span class="text-slate-700 font-medium text-lg">{{ $invoice->issue_date ? \Carbon\Carbon::parse($invoice->issue_date)->format('d/m/Y') : '-' }}</span>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Fecha de Vencimiento</span>
                    <span class="text-rose-600 font-bold text-lg">{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') : '-' }}</span>
                </div>
            </div>
        </div>

        {{-- 3. TABLA DE ÍTEMS --}}
        <div class="px-10 md:px-12 pb-10">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-900 text-white">
                        <th class="py-4 px-6 text-left rounded-l-lg font-semibold w-1/2">Descripción</th>
                        <th class="py-4 px-6 text-center font-semibold">Ciclo</th>
                        <th class="py-4 px-6 text-right font-semibold rounded-r-lg">Importe</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($invoice->items as $item)
                    <tr>
                        <td class="py-5 px-6 text-slate-700 font-medium align-top">
                            {{ $item->description }}
                        </td>
                        <td class="py-5 px-6 text-center text-slate-500 align-top">
                            1
                        </td>
                        <td class="py-5 px-6 text-right font-bold text-slate-800 align-top">
                            {{ $invoice->currency }} {{ number_format($item->total, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- 4. TOTALES --}}
        <div class="px-10 md:px-12 pb-12 flex justify-end">
            <div class="w-full md:w-1/2 lg:w-5/12 bg-slate-50 p-6 rounded-xl space-y-3">
                <div class="flex justify-between text-slate-500 text-sm">
                    <span>Subtotal</span>
                    <span>{{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-slate-500 text-sm">
                    <span>Impuestos</span>
                    <span>{{ $invoice->currency }} {{ number_format($invoice->tax_total, 2) }}</span>
                </div>
                <div class="h-px bg-slate-200 my-2"></div>
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold text-slate-900">Total a Pagar</span>
                    <span class="text-2xl font-bold text-emerald-700">{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- 5. LEGAL --}}
        <div class="bg-slate-50 p-6 text-center border-t border-slate-100">
            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold mb-2">Gracias por confiar en Linea365</p>
            <p class="text-[10px] text-slate-400">
                Esta factura se asimila en todos sus efectos a una letra de cambio de conformidad con el Art. 774 del Código de Comercio.<br>
                Generado electrónicamente por Linea365 System v1.0
            </p>
        </div>
    </div>

</div>

{{-- ESTILOS DE IMPRESIÓN (Transforma la web oscura en papel blanco al imprimir) --}}
<style>
    @media print {
        @page { margin: 0; size: auto; }
        body { background-color: white !important; color: black !important; margin: 0 !important; }
        .no-print, header, footer, nav, aside, .glass { display: none !important; }
        .max-w-4xl { max-width: 100% !important; margin: 0 !important; padding: 20px !important; width: 100% !important; }
        .invoice-paper { box-shadow: none !important; border: 1px solid #ddd !important; border-radius: 0 !important; }
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    }
</style>
@endsection