@php use Bunker\LaravelSpeedDate\Enums\RatingEnum;use Bunker\LaravelSpeedDate\Models\RatingEvent; @endphp
@extends('layouts.app')
@push('styles')
    <style>

    </style>
@endpush
@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Event Details</h4>
                @can('sd_event_create')
                    <button type="button" class="btn btn-success btn-sm"
                            onclick="openUploadModal('{{ $event->id }}')">
                        <i class="bi bi-arrow-up"></i><i class="bi bi-filetype-csv"></i> Participants
                    </button>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <th scope="row">Event Name:</th>
                    <td>{{ $event->name }}</td>
                </tr>
                <tr>
                    <th scope="row">Event Date:</th>
                    <td>{{ $event->happens_on->format('F j, Y h:i A') }}</td>
                </tr>
                <tr>
                    <th scope="row">Event Type:</th>
                    <td>{{ $event->type }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card p-4">
        <div class="row">
            
            <div class="col-12 mb-2">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Participants</h4>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        @if(isset($event->participants) && count($event->participants) > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Nick Name
                                        </th>
                                        @if(auth()->user()->id == 1)
                                            <th>
                                                Last Name
                                            </th>
                                            <th>
                                                Email
                                            </th>
                                            <th>
                                                Phone
                                            </th>
                                            <th>
                                                City
                                            </th>
                                        @endif
                                        <th>
                                            Occupation
                                        </th>
                                        <th>
                                            Birthdate
                                        </th>
                                        <th>
                                            Gender
                                        </th>
                                        <th>
                                            Looking For
                                        </th>
                                        <th>
                                            @if(auth()->user()->id == 1)
                                                Vote Status
                                            @else
                                                Rating
                                            @endif
                                            
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($event->matchedParticipants as $item)
                                {{-- {{dd($item->events->first()->eventRatings->first()->rating)}} --}}
                                    @if($item->id !== auth()->user()->id)
                                        <tr>
                                            <td>
                                                <a href="{{ route('users.show', $item->id) }}"
                                                   style="text-decoration: underline; color: #007bff; text-decoration-color: #007bff;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded-circle overflow-hidden mr-2"
                                                             style="width: 40px; height: 40px;">
                                                            <img src="{{ asset($item->avatar) }}"
                                                                 alt="{{ $item->name }}"
                                                                 class="w-100 h-100">
                                                        </div>
                                                        <span class="ml-2"
                                                              style="margin-left: 8px !important;">{{ $item->name }}</span>
                                                    </div>
                                                </a>

                                            </td>
                                            <td>{{ $item->bio->nickname }}</td>

                                        @if(auth()->user()->id == 1)
                                            <td>{{ $item->bio->lastname }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->bio->phone }}</td>
                                            <td>{{ $item->bio->city }}</td>
                                        @endif
                                            <td>{{ $item->bio->occupation }}</td>
                                            <td>{{ $item->bio->birthdate }}</td>
                                            <td>{{ $item->bio->gender }}</td>
                                            <td>{{ $item->bio->looking_for }}</td>
                                            <td>
                                                @if(auth()->user()->id == 1)
                                                    {{$event->getEventRatingForUser($item)}}
                                                @else
                                                {{ RatingEvent::where([
                                                    ['user_id_from', auth()->user()->id],
                                                    ['user_id_to', $item->id],
                                                    ['event_id', $event->id]
                                                    ])->first()->rating ?? 'No Rating Yet' }}
                                                @endif
                                            </td>
                                            <td>

                                                @if(auth()->user()->hasRole('User'))
                                                    @php
                                                        $alreadyRated = RatingEvent::where([
                                                            ['user_id_from', auth()->user()->id],
                                                            ['user_id_to', $item->id],
                                                            ['event_id', $event->id]
                                                        ])->exists();
                                                    @endphp

                                                    @can('sd_rating_create')
                                                        {{-- @if(!$alreadyRated) --}}
                                                            <a href="#"
                                                               class="btn btn-sm btn-outline-primary mr-2 rate-button" style="width:100px;"
                                                               onclick="openRateModal('{{ $item->email }}', '{{ $event->id }}')"><i
                                                                    class="bi bi-activity"></i> Rate Now</a>
                                                        {{-- @endif --}}
                                                    @endcan
                                                @else
                                                    @can('sd_rating_create')
                                                        <a href="#"
                                                           onclick="confirmDelete('{{ route('speed_date.events.removeParticipant', ['eventId' => $event->id, 'userId' => $item->id]) }}', 'POST', {color: 'danger', text: 'Yes, delete it!'})"
                                                           class="btn btn-danger btn-sm"
                                                           title="{{ __('global.remove') }}">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    @endcan
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            No participants available
                        @endif
                    </div>
                </div>
            </div>
            @can('sd_rating_show')
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Ratings</h4>
                            </div>
                        </div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>User From</th>
                                <th>Rating</th>
                                <th>User To</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($event->eventRatings as $rating)
                                <tr>
                                    <td>
                                        <a href="{{ route('users.show', $rating->userFrom->id) }}"
                                            style="text-decoration: underline; color: #007bff; text-decoration-color: #007bff;">
                                             <div class="d-flex align-items-center">
                                                 <div class="rounded-circle overflow-hidden mr-2"
                                                      style="width: 40px; height: 40px;">
                                                     <img src="{{ asset($rating->userFrom->avatar) }}"
                                                          alt="{{ $rating->userFrom->name }}"
                                                          class="w-100 h-100">
                                                 </div>
                                                 <span class="ml-2"
                                                       style="margin-left: 8px !important;">{{ $rating->userFrom->name }}</span>
                                             </div>
                                         </a>
                                    </td>
                                    <td>{{ $rating->rating }}</td>
                                    <td>
                                        <a href="{{ route('users.show', $rating->userTo->id) }}"
                                            style="text-decoration: underline; color: #007bff; text-decoration-color: #007bff;">
                                             <div class="d-flex align-items-center">
                                                 <div class="rounded-circle overflow-hidden mr-2"
                                                      style="width: 40px; height: 40px;">
                                                     <img src="{{ asset($rating->userTo->avatar) }}"
                                                          alt="{{ $rating->userTo->name }}"
                                                          class="w-100 h-100">
                                                 </div>
                                                 <span class="ml-2"
                                                       style="margin-left: 8px !important;">{{ $rating->userTo->name }}</span>
                                             </div>
                                         </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endcan
        </div>
    </div>

    @can('sd_rating_create')
        <!-- Rating modal -->
        <div class="modal fade" id="rateModal" tabindex="-1" aria-labelledby="rateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rateModalLabel">Rate this user</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('speed_date.ratings.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Hidden field for user email -->
                            <input type="hidden" name="user_email" id="user_email">
                            <input type="hidden" name="event" id="rating_event">
                            <!-- Hidden field for event ID -->
                            <input type="hidden" name="event_id" value="{{ $event->id }}">

                            <!-- Radio buttons for rating options -->
                            @foreach(RatingEnum::toArray() as $rating)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" id="{{ $rating }}"
                                           value="{{ $rating }}">
                                    <label class="form-check-label" for="{{ $rating }}">{{ ucfirst($rating) }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit Rating</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    @can('sd_event_create')
        <!-- upload modals -->
        <div class="modal fade" id="modal-file" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload csv</h1>
                    </div>
                    <form action="{{ route('speed_date.events.uploadUsers') }}" method="POST"
                          enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label for="csv_file" class="form-label">Choose CSV File:</label>
                                <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv">
                                <input type="hidden" id="event" name="event">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection
@push('scripts')
    @can('sd_event_delete')
        @include('components.sweetAlert2')
    @endcan
    <script>
        function openUploadModal(eventId) {
            // Set the event ID in the modal form
            document.getElementById('event').value = eventId;
            // Open the modal
            let csvModal = new bootstrap.Modal(document.getElementById('modal-file'));
            csvModal.show();
        }

        function openRateModal(email, event) {
            // Set the user email in the modal form
            document.getElementById('user_email').value = email;
            document.getElementById('rating_event').value = event;
            // Open the modal
            let rateModal = new bootstrap.Modal(document.getElementById('rateModal'));
            rateModal.show();
        }
    </script>
@endpush
