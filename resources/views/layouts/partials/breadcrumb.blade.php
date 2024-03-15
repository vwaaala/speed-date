@if(!request()->routeIs('dashboard'))
    @php
        $breadCrumbs = [];
        $currentRoute = request()->route()->getName();
        foreach(config('pages') as $page){
            if($page['href'] == $currentRoute){
                $breadCrumbs[] = ['href' => $page['href'], 'text' => $page['text']];
            }else{
                foreach($page['children'] as $child){
                    if($child['href'] == $currentRoute){
                        $breadCrumbs[] = ['href' => $page['href'], 'text' => $page['text']];
                        $breadCrumbs[] = ['href' => $child['href'], 'text' => $child['text']];
                    }
                }
            }
        }
    @endphp
    <div class="d-flex mb-2 justify-content-between">
        <button onclick="window.history.back();" class="btn btn-sm btn-outline-primary"><span
                class="bi bi-arrow-return-left"></span>
            {{ __('global.back_to_list') }}
        </button>
        @if(isset($breadCrumbs))
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('pages')[0]['href']) }}">{{ __(config('pages')[0]['text']) }}</a>
                    </li>
                    @foreach($breadCrumbs as $bread)
                        @if(!request()->routeIs($bread['href']))
                            <li class="breadcrumb-item">
                                <a href="{{ route($bread['href']) }}">{{ __($bread['text']) }}</a>
                            </li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">{{ __($bread['text']) }}</li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        @endif

    </div>
@endif
