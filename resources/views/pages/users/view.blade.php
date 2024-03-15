@extends('layouts.app', ['pageName' => config('pages.users.show')])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <span>{{ __('global.profile') }}</span>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><span
                        class="bi bi-pencil"></span> </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Profile Photo -->
                <div class="col-md-3">
                    <img src="{{ asset($user->avatar) }}" class="img-fluid rounded" alt="Your Profile Photo">
                </div>

                <!-- Name and Email -->
                <div class="col-md-9">
                    <!-- Full Name -->
                    <h3>{{ $user->name }}</h3>

                    <!-- Email with Mail Icon -->
                    <p><strong><i class="bi bi-envelope-check"></i></strong> {{ $user->email }}</p>
                    <!-- Bio -->
                    @if($user->bio)
                        <p><strong>Bio:</strong> {{ $user->bio->nickname }} - {{ $user->bio->city }} - {{ $user->bio->occupation }}</p>
                        <p><strong>Phone:</strong> {{ $user->bio->phone }}</p>
                        <p><strong>Birthdate:</strong> {{ $user->bio->birthdate }}</p>
                        <p><strong>Gender:</strong> {{ $user->bio->gender }}</p>
                        <p><strong>Looking For:</strong> {{ $user->bio->looking_for }}</p>
                    @else
                        <p><strong>Bio:</strong> No bio available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
