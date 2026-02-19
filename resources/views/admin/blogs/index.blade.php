@extends('layouts.admin')

@section('title', __('messages.manage_blogs'))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.manage_blogs') }}</li>
        </ol>
    </nav>
    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">{{ __('messages.back_to_dashboard') }}</a>
</div>
<div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="mb-0">{{ __('messages.manage_blogs') }}</h3>
    <a class="btn btn-brand" href="{{ route('admin.blogs.create') }}"><i class="bi bi-plus-lg"></i> {{ __('messages.add_blog') }}</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>{{ __('messages.title') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.show_on_home') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
            @forelse($blogs as $blog)
                <tr>
                    <td>{{ $blog->title }}</td>
                    <td>
                        <span class="badge {{ $blog->is_published ? 'bg-success' : 'bg-secondary' }}">
                            {{ $blog->is_published ? __('messages.published') : __('messages.draft') }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $blog->show_on_home ? 'bg-primary' : 'bg-light text-dark' }}">
                            {{ $blog->show_on_home ? __('messages.yes') : __('messages.no') }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.blogs.edit', $blog) }}">{{ __('messages.edit') }}</a>
                            <form class="m-0" method="post" action="{{ route('admin.blogs.destroy', $blog) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-outline-danger" type="submit">{{ __('messages.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">{{ __('messages.no_blogs') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $blogs->links('vendor.pagination.admin-template') }}
    </div>
</div>
@endsection
