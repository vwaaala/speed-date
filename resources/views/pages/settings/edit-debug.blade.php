@extends('layouts.app', ['pageName' => config('pages.settings.debug' )])
@section('content')
    @canany(['settings_show', 'settings_create', 'settings_edit', 'settings_delete'])
        <!-- User DataTable -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('pages.settings.debug') }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('setupStep1') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-2">
                        <label class="form-label text-muted" for="app_name">Name your Application <span class="text-danger">*</span></label>
                        <span class="text-primary" data-bs-toggle="tooltip" title="This is the name of your Application"><i class="bi bi-question-circle"></i></span>
                        <input type="text" class="form-control" id="app_name" name="app_name" placeholder="Larabone" value="{{$data['APP_NAME']}}" autofocus required>
                    </div>

                    <div class="mb-2" id="drop-area">
                        <label class="form-label">Logo <small class="text-muted">195p x 60p</small> <span class="text-danger">*</span></label>
                        <div class="icon-shape icon-xxl border rounded position-relative">
                            <span class="position-absolute text-primary" id="preview"><i class="bi bi-image fs-3 text-muted"></i></span>
                            <input id="fileInput" name="logo" class="form-control border-0 opacity-0" type="file" required autofocus>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label text-muted" for="app_env">Select Environment <span class="text-danger">*</span></label>
                            <span class="text-primary" data-bs-toggle="tooltip" title="The environment you want to deploy to. For coding you usually want to use 'local'"><i class="bi bi-question-circle"></i></span>
                            <select class="form-select" id="app_env" name="app_env">
                                @if($data['APP_ENV'] == 'local')
                                    <option value="local">Local</option>
                                    <option value="testing">Testing</option>
                                    <option value="production">Production</option>
                                @elseif($data['APP_ENV'] == 'testing')
                                    <option value="testing">Testing</option>
                                    <option value="local">Local</option>
                                    <option value="production">Production</option>
                                @else
                                    <option value="production">Production</option>
                                    <option value="testing">Testing</option>
                                    <option value="local">Local</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted" for="app_debug">App Debug Mode <span class="text-danger">*</span></label>
                            <span class="text-primary" data-bs-toggle="tooltip" title="APP_DEBUG offers error reporting for development purpose"><i class="bi bi-question-circle"></i></span>
                            <select class="form-select" id="app_debug" name="app_debug">
                                @if($data['APP_DEBUG'] == 'true')
                                    <option value="true">true</option>
                                    <option value="false">false</option>
                                @else
                                    <option value="false">false</option>
                                    <option value="true">true</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label text-muted" for="app_key">App Key <span class="text-danger">*</span></label>
                                <span class="text-primary" data-bs-toggle="tooltip" title="The application key is a unique base64 String. Click if you want a new one for your application"><i class="bi bi-question-circle"></i></span>
                                <input type="text" class="form-control" id="app_key" name="app_key" value="{{$data['APP_KEY']}}" placeholder="Click Button to generate" readonly>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-secondary mt-3" id="generate_key" title="Generate" data-url="{{ route('getNewAppKey') }}"><i class="bi bi-newspaper"></i> Generate Key</button>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label text-muted" for="support_email">Support email <span class="text-danger">*</span></label>
                            <span class="text-primary" data-bs-toggle="tooltip" title="This email will be used for support channel" aria-hidden="true"><i class="bi bi-question-circle"></i></span>
                            <input type="email" class="form-control" id="support_email" name="support_email" value="support@domain.tld" placeholder="support@domain.tld" autofocus required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted" for="phone_first">Site Contact Number <span class="text-danger">*</span></label>
                            <span class="text-primary" data-bs-toggle="tooltip" title="This number will be used as first phone" aria-hidden="true"><i class="bi bi-question-circle"></i></span>
                            <input type="text" class="form-control" id="phone_first" name="phone_first" value="+8801811000000" placeholder="+880 1811 000 000" autofocus required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-muted" for="street">Street <span class="text-danger">*</span></label>
                        <span class="text-primary" data-bs-toggle="tooltip" title="This will be used as street address" aria-hidden="true"><i class="bi bi-question-circle"></i></span>
                        <input type="text" class="form-control" id="street" name="street" value="20/22 Kaminari, Sonngard" placeholder="20/22 Kaminari, Sonngard" autofocus required>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label text-muted" for="city">City <span class="text-danger">*</span></label>
                            <span class="text-primary" data-bs-toggle="tooltip" title="This name will be used as city" aria-hidden="true"><i class="bi bi-question-circle"></i></span>
                            <input type="text" class="form-control" id="city" name="city" value="Khulna" placeholder="Khulna" autofocus required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted" for="country">Country <span class="text-danger">*</span></label>
                            <span class="text-primary" data-bs-toggle="tooltip" title="This name will be used as country" aria-hidden="true"><i class="bi bi-question-circle"></i></span>
                            <input type="text" class="form-control" id="country" name="country" value="Bangladesh" placeholder="Bangladesh" autofocus required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('viewSetup') }}" class="btn btn-outline-danger mt-3"><i class="bi bi-arrow-left"></i> Previous Step</a>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <button type="submit" id="next" class="btn btn-outline-primary mt-3">Next Step <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endcanany
@endsection

@push('scripts')

    @can('settings_delete')
        @include('components.sweetAlert2')
    @endcan
@endpush
