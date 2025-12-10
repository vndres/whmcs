@extends('layouts.frontend')

@section('title', 'Nuevo ticket - Linea365 Clientes')

@section('content')
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-slate-50">
                Nuevo ticket de soporte
            </h1>
            <p class="text-sm text-slate-400 mt-1">
                Cuéntanos qué necesitas y nuestro equipo de soporte te ayudará lo antes posible.
            </p>

            <p class="text-xs text-slate-500 mt-1">
                Cliente: {{ $client->full_name }} (ID #{{ $client->id }}) · {{ $client->email }}
            </p>
        </div>

        <div class="glass rounded-2xl border border-slate-800 p-5">
            <form action="{{ route('tickets.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">
                        Asunto del ticket
                    </label>
                    <input
                        type="text"
                        name="subject"
                        value="{{ old('subject') }}"
                        class="w-full rounded-xl bg-slate-900/60 border border-slate-700 px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Ej: Problema con mi servicio de hosting"
                        required
                    >
                    @error('subject')
                        <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">
                            Departamento
                        </label>
                        <select
                            name="department"
                            class="w-full rounded-xl bg-slate-900/60 border border-slate-700 px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                            <option value="">Selecciona un departamento</option>
                            <option value="Soporte" {{ old('department') === 'Soporte' ? 'selected' : '' }}>Soporte técnico</option>
                            <option value="Facturación" {{ old('department') === 'Facturación' ? 'selected' : '' }}>Facturación</option>
                            <option value="Comercial" {{ old('department') === 'Comercial' ? 'selected' : '' }}>Comercial</option>
                        </select>
                        @error('department')
                            <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">
                            Prioridad
                        </label>
                        <select
                            name="priority"
                            class="w-full rounded-xl bg-slate-900/60 border border-slate-700 px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Baja</option>
                            <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Media</option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>Alta</option>
                        </select>
                        @error('priority')
                            <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">
                        Mensaje
                    </label>
                    <textarea
                        name="message"
                        rows="6"
                        class="w-full rounded-xl bg-slate-900/60 border border-slate-700 px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Describe tu problema o solicitud con el mayor detalle posible."
                        required
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('tickets.index') }}"
                       class="text-xs text-slate-400 hover:text-slate-200">
                        ← Volver a mis tickets
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-500 hover:bg-emerald-400 text-slate-900 shadow-lg shadow-emerald-500/30 transition"
                    >
                        Enviar ticket
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
