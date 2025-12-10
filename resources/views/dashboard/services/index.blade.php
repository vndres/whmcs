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
                    Consulta los servicios activos, pendientes, suspendidos o cancelados de tu cuenta.
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
                    Vincula este usuario a un cliente para poder ver servicios.
                </span>
            </div>
        @elseif ($services->count() === 0)
            <div class="glass rounded-2xl p-5 border border-slate-800 text-sm text-slate-300">
                No tienes servicios activos por el momento.
                <br>
                <span class="text-slate-400 text-xs">
                    Cuando contrates hosting, dominios u otros productos, aparecerán aquí.
                </span>
            </div>
        @else
            <div class="glass rounded-2xl border border-slate-800 overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-800 flex items-center justify-between">
                    <div class="text-sm font-semibold text-slate-100">
                        Servicios de {{ $client->full_name }}
                    </div>
                    <div class="text-[11px] text-slate-400">
                        Mostrando {{ $services->firstItem() }} - {{ $services->lastItem() }}
                        de {{ $services->total() }} servicios
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-slate-200">
                        <thead class="bg-slate-900/80 border-b border-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Producto</th>
                                <th class="px-4 py-3 text-left font-semibold">Dominio / Identificador</th>
                                <th class="px-4 py-3 text-left font-semibold">Servidor</th>
                                <th class="px-4 py-3 text-left font-semibold">Estado</th>
                                <th class="px-4 py-3 text-left font-semibold">Próximo vencimiento</th>
                                <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @foreach ($services as $service)
                                @php
                                    $productName = $service->product?->name ?? 'Servicio sin producto';
                                    $serverName  = $service->server?->name ?? 'Sin servidor';
                                @endphp
                                <tr class="hover:bg-slate-900/60 transition">
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm text-slate-50">
                                            {{ $productName }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            ID servicio: #{{ $service->id }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm text-slate-100">
                                            {{ $service->domain ?? '—' }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            Usuario: {{ $service->username ?? '—' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top text-sm">
                                        {{ $serverName }}
                                        @if($service->server && $service->server->hostname)
                                            <div class="text-[11px] text-slate-500 mt-0.5">
                                                {{ $service->server->hostname }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] {{ $service->status_class }}">
                                            {{ $service->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 align-top text-sm whitespace-nowrap">
                                        {{ $service->next_due_date?->format('d/m/Y') ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-right">
                                        <a href="{{ route('services.show', $service) }}"
                                           class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-semibold btn-outline">
                                            Ver detalle
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($services->hasPages())
                    <div class="px-4 py-3 border-t border-slate-800">
                        {{ $services->links() }}
                    </div>
                @endif
            </div>
        @endif
    </section>
@endsection
