@php use Bunker\LaravelSpeedDate\Enums\EventTypeEnum; @endphp
@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">
@endpush
@section('content')
    @can('user_edit')
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{ __('global.create') }} {{ __('speed_date::speed_date.events') }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('speed_date.events.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-12 mb-2">
                            <label for="name" class="form-label">{{ __('global.name') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                   name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-6 mb-2">
                            <label for="typeSelect" class="form-label">{{ __('global.type') }} <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="typeSelect"
                                    name="type">
                                @foreach(EventTypeEnum::toArray() as $value)
                                    <option value="{{ $value }}" @if($value == old('type')) selected @endif>{{ ucfirst($value) }}</option>
                                @endforeach
                            </select>

                            @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-6 mb-2">
                            <label for="statusSelect" class="form-label">{{ __('global.status') }} <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="statusSelect"
                                    name="status">
                                    <option value="1" @if($value == old('status')) selected @endif>{{ __('Active') }}</option>
                                    <option value="0" @if($value == old('status')) selected @endif>{{ __('Close') }}</option>
                            </select>

                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="happens_on" class="form-label">Happens On</label>
                            <div class="input-group">
                                <input type="text" name="happens_on" value="{{ old('happens_on') }}" class="form-control" id="datepicker" required>
                                <div class="input-group-text" data-target="#"
                                     data-toggle="datetimepicker">
                                    <i class="bi bi-calendar"></i>
                                </div>
                                @error('happens_on')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary mt-5">{{ __('global.create') }}</button>
                </form>
            </div>
        </div>
    @endcan
@endsection

@push('scripts')
    <!-- Initialize datetime picker -->
    <script>
        $(document).ready(function() {
            let currentDate = new Date();
            currentDate.setHours(currentDate.getHours() + 24); // Set the minimum date to 5 hours later

            $('#datepicker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                startDate: currentDate // Set the minimum date
            });
        });

    </script>
@endpush
