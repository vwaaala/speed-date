@php
    use Bunker\LaravelSpeedDate\Enums\GenderEnum;
@endphp
@extends('layouts.app', ['pageName' => config('pages.users.create')])
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="{{ asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
@endpush
@section('content')
    @can('user_edit')
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{ __('global.create') }} {{ __('pages.users.title_singular') }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-12 col-sm-6 mb-2">
                            <label for="name" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                   name="name" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <!-- Input field for user's last name -->
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control"
                                   id="lastname"
                                   name="lastname" value="{{ old('lastname') }}">
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <!-- Input field for user's nick name -->
                            <label for="nickname" class="form-label">Nick Name</label>
                            <input type="text" class="form-control"
                                   id="nickname"
                                   name="nickname" value="{{ old('nickname') }}">
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <label for="email" class="form-label">{{ __('pages.users.fields.email') }} <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                   name="email" required>
                            <div id="emailHelp" class="form-text">{{ __('pages.users.fields.email_helper') }}</div>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <label for="password" class="form-label">{{ __('pages.users.fields.password') }} <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <label for="password_confirmation" class="form-label">{{ __('pages.users.fields.password_confirm') }} <span class="text-danger">*</span></label>
                            <input type="password"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <label for="roleSelect" class="form-label">{{ __('pages.users.fields.roles') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('roles') is-invalid @enderror" id="roleSelect"
                                    name="role">
                                @foreach($roles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-sm-6 mb-2">
                            <label for="statusSelect" class="form-label">{{ __('global.status') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="statusSelect"
                                    name="status">
                                <option value="pending">Pending</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="banned">Banned</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-sm-6 mb-2">
                            <!-- Dropdown for selecting user's status -->
                            <label for="eventSelect" class="form-label">Event <span
                                    class="text-danger">*</span></label>
                            <select class="form-select select2 @error('event') is-invalid @enderror"
                                    id="eventSelect"
                                    name="event">
                                @foreach($events as $item)
                                    <option
                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('event')
                            <div class="invalid-feedback">{{ $message }}</div>
                            <!-- Error message for status select -->
                            @enderror
                        </div>

                        <div class="col-12 col-sm-6">
                            <label for="avatar" class="form-label">{{ __('global.photo') }}</label>
                            <input type="file" class="form-control" id="avatar" name="avatar">
                        </div>
                        
                    <div class="col-12 col-sm-6 mb-2">
                        <!-- Input field for user's city -->
                        <label for="lastname" class="form-label">City</label>
                        <input type="text" class="form-control"
                                id="city"
                                name="city" value="{{ old('city') }}">
                    </div>
                    <div class="col-12 col-sm-6 mb-2">
                        <!-- Input field for user's occupation -->
                        <label for="occupation" class="form-label">Occupation</label>
                        <input type="text" class="form-control"
                                id="occupation"
                                name="occupation" value="{{ old('occupation') }}">
                    </div>
                    <div class="col-12 col-sm-6 mb-2">
                        <!-- Input field for user's phone -->
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control"
                                id="phone"
                                name="phone" value="{{ old('phone') }}">
                    </div>
                    <div class="col-12 col-sm-6 mb-2">
                        <!-- Input field for user's birthdate -->
                        <label for="birthdate" class="form-label">Birthdate</label>
                        <input type="text" class="form-control"
                                id="birthdate"
                                name="birthdate" value="{{ old('birthdate') }}">
                    </div>
                    <div class="col-12 col-sm-6 mb-2">
                        <!-- Dropdown for selecting user's gender -->
                        <label for="gender" class="form-label">Gender <span
                                class="text-danger">*</span></label>
                        <select class="form-select"
                                id="gender"
                                name="gender">
                            @foreach(GenderEnum::toArray() as $value)
                                <option
                                    value="{{ $value }}">{{ ucfirst($value) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 mb-2">
                        <!-- Dropdown for selecting user's lookingfor -->
                        <label for="looking_for" class="form-label">Looking For <span
                                class="text-danger">*</span></label>
                        <select class="form-select"
                                id="looking_for"
                                name="looking_for">
                            @foreach(GenderEnum::toArray() as $value)
                                <option
                                    value="{{ $value }}">{{ ucfirst($value) }}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-5">{{ __('global.create') }}</button>
                </form>
            </div>
        </div>
    @endcan
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $('#birthdate').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true
        });
        $('.select2').select2();
    });
</script>
@endpush