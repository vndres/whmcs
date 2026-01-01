@extends('layouts.frontend')

@section('title', 'Nuevo Ticket')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">

    <div class="mb-8">
        <a href="{{ route('tickets.index') }}" class="text-sm text-slate-400 hover:text-white transition flex items-center gap-2 mb-2">
            &larr; Volver a la lista
        </a>
        <h1 class="text-3xl font-bold text-white">Crear Solicitud de Soporte</h1>
        <p class="text-slate-400 mt-2">Describe tu problema detalladamente para poder ayudarte mejor.</p>
    </div>

    <div class="glass rounded-2xl border border-slate-800 p-8 shadow-2xl">
        <form action="{{ route('tickets.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                {{-- Departamento --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Departamento</label>
                    <select name="department" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:outline-none transition appearance-none">
                        <option value="Soporte Técnico">Soporte Técnico</option>
                        <option value="Facturación">Facturación</option>
                        <option value="Ventas">Ventas</option>
                    </select>
                </div>

                {{-- Prioridad --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Prioridad</label>
                    <select name="priority" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:outline-none transition appearance-none">
                        <option value="low">Baja</option>
                        <option value="medium" selected>Media</option>
                        <option value="high">Alta (Urgencia Crítica)</option>
                    </select>
                </div>
            </div>

            {{-- Asunto --}}
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Asunto</label>
                <input type="text" name="subject" value="{{ old('subject') }}" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:outline-none transition placeholder-slate-600" placeholder="Ej: Error 500 en mi sitio web" required>
                @error('subject')
                    <span class="text-xs text-rose-400">{{ $message }}</span>
                @enderror
            </div>

            {{-- Mensaje --}}
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Mensaje / Descripción</label>
                <textarea name="message" rows="6" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:outline-none transition placeholder-slate-600" placeholder="Describe los pasos para reproducir el error o los detalles de tu consulta..." required>{{ old('message') }}</textarea>
                @error('message')
                    <span class="text-xs text-rose-400">{{ $message }}</span>
                @enderror
            </div>

            {{-- Botones --}}
            <div class="pt-4 flex justify-end gap-4">
                <a href="{{ route('tickets.index') }}" class="px-6 py-3 rounded-xl border border-slate-700 text-slate-300 hover:bg-slate-800 transition text-sm font-bold">
                    Cancelar
                </a>
                <button type="submit" class="px-8 py-3 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl font-bold text-sm shadow-lg shadow-emerald-900/20 transition transform hover:-translate-y-0.5">
                    Enviar Ticket
                </button>
            </div>

        </form>
    </div>
</div>
@endsection