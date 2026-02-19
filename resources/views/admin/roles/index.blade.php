@extends('layouts.admin')

@section('title', __('messages.manage_roles'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active">{{ __('messages.manage_roles') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>

<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h3 class="mb-1">{{ __('messages.manage_roles') }}</h3>
        <div class="text-muted small">{{ __('messages.manage_roles_hint') }}</div>
    </div>
    <a class="btn btn-brand" href="{{ route('admin.roles.create') }}">
        <i class="bi bi-plus-lg"></i> {{ __('messages.add_role') }}
    </a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>{{ __('messages.role') }}</th>
                    <th>{{ __('messages.name') }} (slug)</th>
                    <th>{{ __('messages.permissions') }}</th>
                    <th style="width:60px" class="text-center">{{ __('messages.total_users') }}</th>
                    <th style="width:120px">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($roles as $role)
            @php
                $badgeColor = match($role->name) {
                    'superadmin' => 'danger',
                    'admin'      => 'warning',
                    default      => 'secondary',
                };
                $perms = $role->permissions ?? [];
                $all   = array_keys(\App\Models\Role::SECTIONS);
            @endphp
            <tr>
                <td>
                    <span class="badge bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }} rounded-pill px-3 py-2 fs-6 fw-semibold">
                        {{ $role->label }}
                    </span>
                    @if($role->is_system)
                        <span class="badge bg-light text-secondary ms-1" style="font-size:.65rem">system</span>
                    @endif
                </td>
                <td><code class="text-secondary">{{ $role->name }}</code></td>
                <td>
                    @if($role->name === 'superadmin')
                        <span class="text-success small"><i class="bi bi-check-all"></i> {{ __('messages.all_sections') }}</span>
                    @elseif(empty($perms))
                        <span class="text-muted small">—</span>
                    @else
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($perms as $p)
                                <span class="badge bg-light text-dark border" style="font-size:.7rem">{{ $p }}</span>
                            @endforeach
                        </div>
                    @endif
                </td>
                <td class="text-center">
                    <span class="badge bg-secondary-subtle text-secondary">{{ $role->users_count }}</span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.roles.edit', $role) }}"
                           title="{{ __('messages.edit') }}">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if(!$role->is_system)
                        <form method="post" action="{{ route('admin.roles.destroy', $role) }}" class="m-0"
                              onsubmit="return confirm('{{ __('messages.delete') }}?')">
                            @csrf @method('delete')
                            <button class="btn btn-sm btn-outline-danger" type="submit" title="{{ __('messages.delete') }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
