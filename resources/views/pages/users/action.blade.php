<div class="btn-group">
    @if(Route::currentRouteName() == 'users.index' && !request()->has('show_deleted'))
        @can('user_show')
            <a href="{{ route('users.show', $id ?? $user->id) }}" class="btn btn-sm btn-primary" title="{{ __('global.show') }}">
                <span class="bi bi-eye"></span> <!-- Bootstrap eye icon -->
            </a>
        @endcan
        @can('user_edit')
            <a href="{{ route('users.edit', $id ?? $user->id) }}" class="btn btn-sm btn-warning" title="{{ __('global.edit') }}">
                <span class="bi bi-pencil"></span> <!-- Bootstrap pencil icon -->
            </a>
        @endcan
    @else
        <!-- Display "Retrieve" button if show_deleted parameter is set -->
        @can('user_delete')
            <a href="{{ route('users.retrieveDeleted', $id ?? $user->id) }}" class="btn btn-sm btn-success"
               title="{{ __('global.restore') }}">
                <span class="bi bi-arrow-return-left"></span> <!-- Bootstrap arrow-return-left icon -->
            </a>
        @endcan
    @endif

    @can('user_delete')
        <a onclick="confirmDelete('{{ request()->has('show_deleted') ? route('users.forceDelete', $id) : route('users.destroy', $id) }}')" href="#" class="btn btn-sm btn-danger"
           title="{{ __('global.delete') }}">
            <span class="bi bi-trash"></span> <!-- Bootstrap arrow-return-left icon -->
        </a>
    @endcan
</div>