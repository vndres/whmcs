@extends('layouts.frontend')

@section('title', 'Dominio ' . ($domain->domain ?? '') . ' - Linea365 Clientes')

@section('content')
    @php
        $status = $domain->status ?? 'pending';

        $statusLabel = match ($status) {
            'active'   => 'Activo',
            'pending'  => 'Pendiente',
            'suspended'=> 'Suspendido',
            'cancelled'=> 'Cancelado',
            default    => ucfirst($status),
        };

        $statusClass = match ($status) {
            'active'   => 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/40',
            'suspended'=> 'bg-amber-500/15 text-amber-300 border border-amber-500/40',
            'cancelled'=> 'bg-slate-600/30 text-slate-200 border border-slate-500/50',
            'pending'  => 'bg-yellow-500/15 text-yellow-300 border border-yellow-500/40',
            default    => 'bg-slate-700/40 text-slate-200 border border-slate-500/40',
        };
    @endphp

    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Dominio {{ $domain->domain ?? '(sin dominio)' }}
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Detalle del servicio de dominio asociado a tu cuenta.
                </p>

                <p class="text-xs text-slate-500 mt-1">
                    Cliente: {{ $client->full_name }} (ID #{{ $client->id }}) · {{ $client->email }}<br>
                    Servicio ID: {{ $domain->id }}
                </p>
            </div>

            <div class="text-right space-y-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold {{ $statusClass }}">
                    {{ $statusLabel }}
                </span>
                <div class="text-xs text-slate-400">
                    Creado: {{ $domain->created_at?->format('d/m/Y H:i') ?? '—' }}<br>
                    Actualizado: {{ $domain->updated_at?->format('d/m/Y H:i') ?? '—' }}
                </div>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="glass rounded-2xl border border-slate-800 p-5">
                <h2 class="text-sm font-semibold text-slate-100 mb-3">
                    Información del dominio
                </h2>

                <dl class="space-y-2 text-sm text-slate-200">
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Dominio</dt>
                        <dd class="font-medium">
                            {{ $domain->domain ?? 'Sin dominio' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Producto</dt>
                        <dd class="font-medium">
                            {{ $domain->product->name ?? 'Producto no disponible' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Servidor</dt>
                        <dd class="font-medium">
                            {{ $domain->server->name ?? 'No asignado' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Estado</dt>
                        <dd class="font-medium">
                            {{ $statusLabel }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="glass rounded-2xl border border-slate-800 p-5">
                <h2 class="text-sm font-semibold text-slate-100 mb-3">
                    Fechas y ciclo de facturación
                </h2>

                <dl class="space-y-2 text-sm text-slate-200">
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Fecha de registro</dt>
                        <dd class="font-medium">
                            {{ $domain->activation_date?->format('d/m/Y') ?? '—' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Próximo vencimiento</dt>
                        <dd class="font-medium">
                            {{ $domain->next_due_date?->format('d/m/Y') ?? '—' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Fecha de alta</dt>
                        <dd class="font-medium">
                            {{ $domain->created_at?->format('d/m/Y') ?? '—' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Fecha de baja</dt>
                        <dd class="font-medium">
                            {{ $domain->cancellation_date?->format('d/m/Y') ?? '—' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-between text-xs text-slate-500">
            <a href="{{ route('domains.index') }}" class="text-emerald-400 hover:text-emerald-300">
                ← Volver al listado de dominios
            </a>

            <button
                type="button"
                class="px-3 py-1.5 rounded-lg text-[11px] font-semibold border border-slate-700 text-slate-200 hover:bg-slate-800/80 transition"
                disabled
            >
                Administrar DNS (próximamente)
            </button>
        </div>
    </section>
@endsection
