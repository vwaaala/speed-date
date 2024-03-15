@extends('layouts.app', ['pageName' => config('pages.dashboard')])
@push('styles')
    <style>
        .card .card .d-icons i {
            transition: .3s ease-in-out;
        }

        .card .card:hover .d-icons i {
            font-size: 2rem;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row g-6 mb-6">
                @foreach($packet['cards'] as $item)
                    <div class="col-xl-3 col-sm-6 col-12 pb-sm-2">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span
                                            class="h6 font-semibold text-muted text-sm d-block mb-2">{{ $item['label'] }}</span>
                                        <span class="h3 font-bold mb-0">{{ $item['count'] }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape d-icons rounded-circle">
                                            <i class="{{ $item['icon'] }}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 mb-0 text-sm">
                                    <span class="badge badge-pill bg-soft-success text-success me-2">
                                        <i class="bi bi-arrow-up me-1"></i>{{ $item['percent'] }}%
                                    </span>
                                    <span class="text-nowrap text-xs text-muted">{{ $item['message'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
