@php
use Bunker\LaravelSpeedDate\Enums\GenderEnum;
@endphp
@extends('layouts.app')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="{{ asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
@endpush
@section('content')
<div class="card p-4">
    <div class="row">
        <div class="col-lg-6 col-md-12 col-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('global.edit') }} {{ __('pages.users.title_singular') }}</h5>
                    <!-- Card title for basic information -->
                </div>
                <div class="card-body">
                    <!-- Form for updating users basic information -->
                    <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                        @method('PUT') <!-- Method spoofing to use PUT method -->
                        @csrf <!-- CSRF protection -->

                        <div class="row">
                            <div class="col-12 mb-2">
                                <!-- Input field for user's name -->
                                <label for="name" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                <!-- Error message for name input -->
                                @enderror
                            </div>

                            <div class="col-12 mb-2">
                                <!-- Input field for user's email (disabled) -->
                                <label for="email" class="form-label">{{ __('pages.users.fields.email') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}" {{ auth()->user()->id == 1 && auth()->user()->id != $user->id ? '' : 'disabled'}}>
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.
                                </div>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                <!-- Error message for email input -->
                                @enderror
                            </div>

                            <div class="col-12 mb-2">
                                <!-- Input field for users's avatar -->
                                <label for="avatar" class="form-label">{{ __('global.photo') }}</label>
                                <div class="row">
                                    <div class="col-10">
                                        <input type="file" class="form-control image @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
                                        <img src="" style="width: 200px;display: none;" class="show-image">
                                        @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        <!-- Error message for avatar input -->
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <!-- Displaying users's avatar -->
                                        <img src="{{ asset($user->avatar) }}" alt="Avatar" class="rounded-circle " height="30">
                                    </div>
                                </div>
                            </div>



                            <div class="col-12 mt-2">
                                <!-- Button to submit users update -->
                                <button type="submit" class="btn btn-primary">{{ __('global.update') }} {{ __('pages.users.title_singular') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#birthdate').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true
        });
        $('.select2').select2();
    });
</script>
@endpush