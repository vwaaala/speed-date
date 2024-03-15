@extends('layouts.app', ['pageName' => config('pages.roles.edit')]) <!-- Extending the layout from the 'app.blade.php' file -->

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ __('pages.roles.title_singular') }} {{ __('global.edit') }}</h5> <!-- Card title for basic information -->
        </div>
        <div class="card-body">
            <!-- Form for updating users basic information -->
            <form method="POST" action="{{ route('roles.update', $role->id) }}">
                @method('PUT') <!-- Method spoofing to use PUT method -->
                @csrf <!-- CSRF protection -->

                <div class="row">
                    <div class="col-lg-6 col-md-12 col-12">
                        <!-- Input field for users's name -->
                        <label for="name" class="form-label">{{ __('pages.roles.fields.title') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                               name="name" value="{{ $role->name }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div> <!-- Error message for name input -->
                        @enderror
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <strong>{{ __('pages.permissions.title') }}: <span class="text-danger">*</span></strong>
                            <div class="form-group">
                                @foreach ($permissions as $permission)
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="{{ $permission['id'] }}"
                                               class="name" {{ $role->hasPermissionTo( $permission['name']) ? 'checked' : '' }}>
                                        {{ $permission['name'] }}</label>
                                @endforeach
                            </div>
                    </div>

                    <div class="col-12 mt-2">
                        <!-- Button to submit users update -->
                        <button type="submit" class="btn btn-primary">{{ __('global.update') }} {{ __('pages.roles.title_singular') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection <!-- Closing the content section -->
