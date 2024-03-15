@extends('layouts.app', ['pageName' => 'roles.index'])
@section('content')
    @can('role_show')
        <div class="card mt-2">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('pages.roles.title') }}</h4>
                    @can('role_create')
                        <a href="{{ route('roles.create') }}" class="btn btn-sm btn-success">
                            <i class="bi bi-plus-circle"></i> {{ __('global.add') }} {{ __('pages.roles.title_singular') }}
                        </a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('pages.roles.title_singular') }}</th>
                        <th scope="col" style="width: 250px;">{{ __('global.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $role->name }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('roles.show', $role->id) }}"
                                       class="btn btn-primary btn-sm"
                                       title="{{ __('global.show') }}">
                                        <i class="bi bi-eye" data-bs-title="Default tooltip"></i>
                                    </a>
                                    @can('role_edit')
                                        <a href="{{ $role->id ===1 ? '#' : route('roles.edit', $role->id) }}"
                                           class="{{ $role->id ===1 ? 'disabled' : ''  }} btn btn-warning btn-sm"
                                           title="{{ __('global.edit') }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endcan
                                    @can('role_delete')
                                        <a href="#" onclick="confirmDelete('{{ route('roles.destroy', $role->id) }}', 'DELETE', {color: 'danger', text: 'Yes, delete it!'})"
                                           class="btn btn-danger btn-sm"
                                           title="{{ __('global.delete') }}">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td colspan="3">
                        <span class="text-danger">
                            <strong>{{ __('pages.roles.not_found') }}</strong>
                        </span>
                        </td>
                    @endforelse
                    </tbody>
                </table>

                {{ $roles->links() }}

            </div>
        </div>
    @endcan
@endsection
@push('scripts')
    @can('user_delete')
        @include('components.sweetAlert2')
    @endcan
@endpush
