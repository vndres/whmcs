@extends('layouts.frontend')

@section('title', 'Mis servicios - Linea365 Clientes')

@section('content')
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Mis servicios
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Aquí verás todos los servicios de hosting, dominios u otros productos asociados a tu cuenta.
                </p>
            </div>

            <div class="text-xs text-slate-400 text-right">
                Sesión iniciada como
                <span class="text-slate-100 font-medium">{{ $user->email }}</span><br>
                @if($client)
                    <span class="text-[11px] text-slate-500">
                        Cliente: {{ $client->full_name }} (ID #{{ $client->id }})
                    </span>
                @endif
            </div>
        </div>

        @if (!$client)
            <div class="glass rounded-2xl p-5 border border-slate-800 text-sm text-slate-300">
                Tu usuario aún no tiene un perfil de cliente asociado.
                <br>
                <span class="text-slate-400 text-xs">
                    Esto se crea automáticamente al registrarte. Si estás usando datos importados, verifica en la base de datos que la tabla <code>clients</code>
                    tenga el campo <code>user_id</code> vinculado a tu usuario.
                </span>
            </div>
        @elseif ($services->count() === 0)
            <div class="glass rounded-2xl p-5 border border-slate-800 text-sm text-slate-300">
                Por el momento no tienes servicios asociados a tu cuenta.
                <br>
                <span class="text-slate-400 text-xs">
                    Cuando contrates un plan de hosting, dominio o cualquier otro producto, aparecerá listado aquí.
                </span>
            </div>
        @else
            <div class="glass rounded-2xl border border-slate-800 overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-800 flex items-center justify-between">
                    <div class="text-sm font-semibold text-slate-100">
                        Servicios de {{ $client->full_name }}
                    </div>
                    <div class="text-[11px] text-slate-400">
                        Total: {{ $services->total() }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-slate-200">
                        <thead class="bg-slate-900/80 border-b border-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Servicio</th>
                                <th class="px-4 py-3 text-left font-semibold">Producto</th>
                                <th class="px-4 py-3 text-left font-semibold">Servidor</th>
                                <th class="px-4 py-3 text-left font-semibold">Estado</th>
                                <th class="px-4 py-3 text-left font-semibold">Próximo vencimiento</th>
                                <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @foreach ($services as $service)
                                <tr class="hover:bg-slate-900/60 transition">
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm text-slate-50">
                                            {{ $service->display_name }}
                                        </div>
                                        <div class="text-[11px] text-slate-400 mt-0.5">
                                            ID: #{{ $service->id }}
                                            @if($service->username)
                                                · Usuario: {{ $service->username }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm">
                                            {{ $service->product->name ?? 'Producto no encontrado' }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            {{ $service->product->type ?? '—' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        @if ($service->server)
                                            <div class="text-sm">
                                                {{ $service->server->name }}
                                            </div>
                                            <div class="text-[11px] text-slate-500 mt-0.5">
                                                {{ $service->server->hostname }}
                                            </div>
                                        @else
                                            <span class="text-[11px] text-slate-500">Sin servidor asignado</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] {{ $service->status_badge_class }}">
                                            {{ $service->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 align-top text-sm">
                                        @if ($service->next_due_date)
                                            {{ $service->next_due_date->format('d/m/Y') }}
                                        @else
                                            <span class="text-slate-500 text-xs">No definido</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 align-top text-right">
                                        <a href="#"
                                           class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-semibold btn-outline">
                                            Ver detalles
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($services->hasPages())
                    <div class="px-4 py-3 border-t border-slate-800">
                        <div class="text-[11px] text-slate-400 mb-2">
                            Mostrando {{ $services->firstItem() }}–{{ $services->lastItem() }} de {{ $services->total() }} servicios
                        </div>
                        <div class="text-xs">
                            {{ $services->links() }}
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </section>
@endsection
