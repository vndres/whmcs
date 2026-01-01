@extends('layouts.frontend')

@section('title', 'Servicio #' . $service->id . ' - Linea365 Clientes')

@section('content')
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        @php
            $productName = $service->product?->name ?? 'Servicio sin producto';
            $serverName  = $service->server?->name ?? 'Sin servidor';
        @endphp

        <div class="flex items-start justify-between mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    {{ $productName }}
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Detalle del servicio, estado, servidor asignado y datos de acceso.
                </p>
                <p class="text-xs text-slate-500 mt-2">
                    Cliente: {{ $client->full_name }} (ID #{{ $client->id }})<br>
                    Correo: {{ $client->email }}
                </p>
            </div>

            <div class="text-right space-y-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold {{ $service->status_class }}">
                    {{ $service->status_label }}
                </span>
                <div class="text-xs text-slate-400">
                    Activación: {{ $service->activation_date?->format('d/m/Y') ?? '—' }}<br>
                    Próximo vencimiento: {{ $service->next_due_date?->format('d/m/Y') ?? '—' }}<br>
                    Cancelación: {{ $service->cancellation_date?->format('d/m/Y') ?? '—' }}
                </div>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 mb-6">
            <div class="glass rounded-2xl border border-slate-800 p-5">
                <h2 class="text-sm font-semibold text-slate-100 mb-3">
                    Información del servicio
                </h2>

                <dl class="space-y-2 text-sm text-slate-200">
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">ID servicio</dt>
                        <dd class="font-medium">#{{ $service->id }}</dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Dominio / Identificador</dt>
                        <dd class="font-medium">
                            {{ $service->domain ?? '—' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Servidor</dt>
                        <dd class="font-medium">
                            {{ $serverName }}
                        </dd>
                    </div>

                    @if($service->server && $service->server->hostname)
                        <div class="flex justify-between gap-4">
                            <dt class="text-slate-400">Hostname</dt>
                            <dd class="font-medium">
                                {{ $service->server->hostname }}
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>

            <div class="glass rounded-2xl border border-slate-800 p-5">
                <h2 class="text-sm font-semibold text-slate-100 mb-3">
                    Datos de acceso (demo)
                </h2>

                <p class="text-xs text-slate-400 mb-3">
                    Estos datos son de demostración. Más adelante podemos conectar acceso directo a cPanel
                    u otros paneles de control.
                </p>

                <dl class="space-y-2 text-sm text-slate-200">
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Usuario</dt>
                        <dd class="font-medium">
                            {{ $service->username ?? '—' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Contraseña</dt>
                        <dd class="font-medium">
                            @if($service->password)
                                ********
                                <span class="text-[11px] text-slate-500 ml-1">
                                    (oculta por seguridad)
                                </span>
                            @else
                                —
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="glass rounded-2xl border border-slate-800 p-5 mb-6">
            <h2 class="text-sm font-semibold text-slate-100 mb-3">
                Configuración técnica (JSON)
            </h2>

            @if(is_array($service->config) && !empty($service->config))
                <pre class="text-[11px] bg-slate-950/70 rounded-xl p-3 text-slate-200 overflow-auto max-h-64">
{{ json_encode($service->config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}
                </pre>
            @else
                <p class="text-xs text-slate-400">
                    Este servicio todavía no tiene configuración técnica guardada en el campo <code>config</code>.
                </p>
            @endif
        </div>

        <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
            <a href="{{ route('services.index') }}" class="text-emerald-400 hover:text-emerald-300">
                ← Volver al listado de servicios
            </a>
        </div>
    </section>
@endsection
