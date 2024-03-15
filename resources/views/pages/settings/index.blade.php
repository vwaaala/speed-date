@extends('layouts.app', ['pageName' => config('pages.settings.index')])
@section('content')
    @canany(['user_show', 'user_create', 'user_edit', 'user_delete'])
        <!-- User DataTable -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('pages.settings.title') }}</h4>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">{{ __('global.name') }}</th>
                          <th scope="col">{{ __('global.description') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($packet as $key => $value)
                          <tr>
                              <th scope="row">{{ $loop->iteration }}</th>
                              <td>{{ $key }}</td>
                              <td>{{ $value }}</td>
                          </tr>
                      @endforeach

                      </tbody>
                  </table>
            </div>
        </div>
    @endcanany
@endsection

@push('scripts')

    @can('user_delete')
        @include('components.sweetAlert2')
    @endcan
@endpush
