@extends('layouts.frontend')

@section('title', $categoryTitle . ' - Linea365')

@section('content')
    {{-- ENCABEZADO SIMPLE --}}
    <section class="relative pt-12 pb-12 bg-slate-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                    {{ $categoryTitle }}
                </h1>
                <p class="text-slate-400 max-w-2xl">
                    Infraestructura premium para tu proyecto.
                </p>
            </div>
        </div>
    </section>

    {{-- LISTA DE PLANES --}}
    <section class="py-12 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if($groupedProducts->isEmpty())
                <div class="glass rounded-2xl p-10 text-center border border-slate-800">
                    <p class="text-slate-400 text-lg">No hay planes disponibles en esta categoría actualmente.</p>
                </div>
            @else
                
                {{-- Bucle para recorrer Grupos --}}
                @foreach($groupedProducts as $groupName => $products)
                    
                    {{-- Si hay grupos con nombres distintos al título, los mostramos como subtítulos --}}
                    @if($groupedProducts->count() > 1 && $groupName != $categoryTitle)
                        <h2 class="text-2xl font-bold text-white mb-6 mt-8 flex items-center gap-3">
                            <span class="h-6 w-1 bg-emerald-500 rounded-full block"></span>
                            {{ $groupName }}
                        </h2>
                    @endif

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                        @foreach($products as $product)
                            @php
                                $isFeatured = ($products->count() == 3 && $loop->iteration == 2);
                                $cardClass = $isFeatured 
                                    ? 'border-emerald-500/50 bg-slate-800/80 scale-105 shadow-2xl shadow-emerald-500/10 z-10' 
                                    : 'border-slate-800 bg-slate-900/40 hover:border-slate-600 hover:bg-slate-800/40';
                                $btnClass = $isFeatured 
                                    ? 'bg-emerald-500 text-slate-900 hover:bg-emerald-400' 
                                    : 'bg-slate-700 text-white hover:bg-slate-600';
                            @endphp

                            <div class="rounded-2xl p-6 flex flex-col border transition duration-300 {{ $cardClass }}">
                                @if($isFeatured)
                                    <div class="absolute top-0 right-0 p-4">
                                        <span class="px-2 py-1 rounded text-[10px] font-bold bg-emerald-500 text-slate-900 uppercase tracking-wide">Popular</span>
                                    </div>
                                @endif

                                <div class="mb-6">
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $product->name }}</h3>
                                    <p class="text-sm text-slate-400 min-h-[40px]">{{ Str::limit(strip_tags($product->description), 80) }}</p>
                                </div>

                                <div class="mb-6 pb-6 border-b border-slate-700/50">
                                    <div class="flex items-baseline gap-1">
                                        @if($product->type == 'domain')
                                            <span class="text-3xl font-bold text-white">${{ number_format($product->price_yearly, 2) }}</span>
                                            <span class="text-sm text-slate-400">/año</span>
                                        @else
                                            <span class="text-3xl font-bold text-white">${{ number_format($product->price_monthly, 2) }}</span>
                                            <span class="text-sm text-slate-400">/mes</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Features List --}}
                                <div class="flex-1 mb-8 text-sm text-slate-300 space-y-2 feature-list">
                                    {!! $product->description !!}
                                </div>

                                <a href="{{ route('cart.configure', $product->id) }}" 
                                   class="w-full py-3 rounded-xl text-center font-bold transition {{ $btnClass }}">
                                    {{ $product->type == 'domain' ? 'Registrar' : 'Contratar' }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <style>
        .feature-list ul { list-style: none; padding: 0; }
        .feature-list li { position: relative; padding-left: 1.5rem; margin-bottom: 0.5rem; }
        .feature-list li::before { content: '✓'; color: #34d399; position: absolute; left: 0; font-weight: bold; }
    </style>
@endsection