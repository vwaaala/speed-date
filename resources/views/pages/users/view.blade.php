@extends('layouts.app', ['pageName' => config('pages.users.show')])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <span>{{ __('global.profile') }}</span>
                <a href="{{ route('speed_date.events.index') }}" class="btn btn-warning">Event</a>
                @if($user->id == auth()->user()->id)
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><span
                        class="bi bi-pencil"></span> </a>
                @endif
            </div>

        </div>

        <div class="card-body">
            <div class="row">
                <!-- Profile Photo -->
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                    <img src="{{ asset($user->avatar) }}" class="img-fluid rounded" style="height:200px" alt="Your Profile Photo">
                </div>

                <!-- Name and Email -->
                <div class="col-md-9">
                    <!-- Full Name -->
                    <h3>{{ $user->name }}</h3>

                    @if(auth()->user()->id == 1 || auth()->user()->id == $user->id)

                    <!-- Email with Mail Icon -->
                    <p><strong><i class="bi bi-envelope-check"></i></strong> {{ $user->email }}</p>
                        @if($user->bio)
                            <p><strong>Last Name:</strong> {{ $user->bio->lastname }}</p>
                            <p><strong>Nick Name:</strong> {{ $user->bio->nickname }}</p>
                            <p><strong>City:</strong> {{ $user->bio->city }}</p>
                            <p><strong>Occupation:</strong> {{ $user->bio->occupation }}</p>
                            <p><strong>Phone:</strong> {{ $user->bio->phone }}</p>
                            <p><strong>Birthdate:</strong> {{ $user->bio->birthdate }}</p>
                        @endif
                    @endif

                    <!-- Bio -->
                    @if($user->bio)
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
