@extends('layouts.app')
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ __('Events') }}</h4>
                @if(isset($events) && count($events) > 0)
                    <form action="#" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                   placeholder="{{ __('global.search') }}..."
                                   value="{{ $searchQuery ?? '' }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
        <div class="card-body table-responsive">
            <!-- Table to display permissions -->
            @if(isset($events) && count($events) > 0)
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <!-- Column headers -->
                        <th scope="col">Happens on</th>
                        <th scope="col">Name</th>
                        <th scope="col">Participants</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Loop through permissions and display each permission -->
                    @foreach($events as $key => $value)
                        <tr>
                            <!-- Output the row number -->
                            <th scope="row">{{ $loop->iteration }}</th>
                            <!-- Display permissions name and description -->
                            <td>{{ $value->happens_on->format('F j, Y') }}
                            </td>
                            <td>{{ $value->name }}</td>
                            <td>{{ count($value->participants) }}</td>
                            <td>
                                @if($value->status == 1)
                                    <i class="bi bi-calendar2-check text-primary"></i>
                                @else
                                    <i class="bi bi-calendar-x text-success"></i>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    @can('sd_event_create')
                                        <button type="button" class="btn btn-primary btn-sm"
                                                onclick="openModal('{{ $value->id }}')">
                                            <i class="bi bi-arrow-up"></i><i class="bi bi-filetype-csv"></i>
                                        </button>
                                    @endcan
                                    @can('sd_event_show')
                                        <a href="{{ route('speed_date.events.show', $value->id) }}"
                                           class="btn btn-success btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endcan
                                    @can('sd_event_delete')
                                        <a href="{{ route('speed_date.events.edit', $value->id) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('speed_date.events.finalizeEvent', $value->id) }}"
                                            class="btn btn-primary btn-sm">
                                             <i class="bi bi-check-circle-fill"></i>
                                         </a>
                                    @endcan
                                    @can('sd_event_delete')
                                        <a href="#"
                                           onclick="confirmDelete('{{ route('speed_date.events.destroy', $value->id) }}', 'DELETE', {color: 'danger', text: 'Yes, delete it!'})"
                                           class="btn btn-danger btn-sm"
                                           title="{{ __('global.delete') }}">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <!-- Pagination links -->
                    <tfoot>
                    <tr>
                        <td colspan="3"
                            class="text-center">{{ $events->appends(['search' => $searchQuery])->onEachSide(5)->links() }}</td>
                    </tr>
                    </tfoot>
                </table>
            @else
                No events available
            @endif
        </div>
    </div>

    <!-- upload modals -->
    <div class="modal fade" id="modal-file" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Upload csv</h1>
                </div>
                <form action="{{ route('speed_date.events.uploadUsers') }}" method="POST" enctype="multipart/form-data">
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

@endsection
@push('scripts')
    @can('sd_event_delete')
        @include('components.sweetAlert2')
    @endcan
    <script>
        function openModal(eventId) {
            // Set the event ID in the modal form
            document.getElementById('event').value = eventId;
            // Open the modal
            let csvModal = new bootstrap.Modal(document.getElementById('modal-file'));
            csvModal.show();
        }
    </script>
@endpush
