@extends('layouts.app', ['pageName' => config('pages.permissions.index')])
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ __('pages.permissions.title') }}</h4>
                <form action="#" method="GET" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="{{ __('global.search') }}..."
                               value="{{ $searchQuery ?? '' }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <!-- Table to display permissions -->
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <!-- Column headers -->
                    <th scope="col">{{ __('pages.permissions.title') }} {{ __('pages.permissions.fields.title') }}</th>
                </tr>
                </thead>
                <tbody>
                <!-- Loop through permissions and display each permission -->
                @foreach($permissions as $key => $value)
                    <tr>
                        <!-- Output the row number -->
                        <th scope="row">{{ $loop->iteration + $offset }}</th>
                        <!-- Display permissions name and description -->
                        <td>{{ $value->name }}</td>
                    </tr>
                @endforeach
                </tbody>
                <!-- Pagination links -->
                <tfoot>
                <tr>
                    <td colspan="3"
                        class="text-center">{{ $permissions->appends(['search' => $searchQuery])->onEachSide(5)->links() }}</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
