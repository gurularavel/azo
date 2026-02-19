@extends('layouts.admin')

@section('title', __('messages.manage_plans'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.manage_plans') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>
<div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="mb-0">{{ __('messages.manage_plans') }}</h3>
    <a class="btn btn-brand" href="{{ route('admin.plans.create') }}">{{ __('messages.add_plan') }}</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.price') }}</th>
                    <th>{{ __('messages.usage_limit_label') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($plans as $plan)
                <tr>
                    <td>{{ $plan->name }}</td>
                    <td>{{ number_format($plan->price, 2) }} ₼</td>
                    <td>{{ $plan->usage_limit }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.plans.edit', $plan) }}">{{ __('messages.edit') }}</a>
                            <form method="post" action="{{ route('admin.plans.destroy', $plan) }}" class="m-0">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-outline-danger" type="submit">{{ __('messages.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
