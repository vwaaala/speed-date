
# bunker/laravel-localization

this package implements cookie based localization on laravel v10.40.
## Installation

Install the package with composer

```bash
  cd to-your-laravel-project-home-directory
  composer require bunker/laravel-localization
```
next add this in Kernel.php

```bash
    protected $middlewareGroups = [
        'web' => [
            //
            \Bunker\LaravelLocalization\Middleware\SetLocale::class
        ],
```
## Documentation
this middleware assumes that you a panel.php file in your project's config directory. in our case, mostly we use this config/panel.php in a scratch project. note that this package only need 'primary_language', 'available_languages'


```bash
    <?php
    return [
        'avatar' => "/assets/images/avatar/avatar.jpg",
        'avatar_path' => "/assets/images/avatar/",
        'date_format' => 'Y-m-d',
        'time_format' => 'H:i:s',
        'primary_language' => 'en',
        'available_languages' => ['en' => 'English', 'bd' => 'Bengali', 'sp' => 'Spanish'],
        'registration_default_role' => 'User'
    ];

```
add this in your blade file to change language

```bash
    <ul class="navbar-nav">
        @if(count(config('panel.available_languages', [])) > 1)
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ strtoupper(app()->getLocale()) }}
            </a>
            <div class="dropdown-menu" aria-labelledby="languageDropdown">
                @foreach(config('panel.available_languages') as $langLocale => $langName)
                <a class="dropdown-item {{ app()->getLocale() == $langLocale ? 'd-none': '' }}" href="{{ url()->current() }}?lang={{ $langLocale }}">{{ $langName }}</a>
                @endforeach
            </div>
        </li>
        @endif
    </ul>

```

now every route which has 'web' middleware attached, will be localized.
## API Reference

#### Change language

```http
  GET example.com?lang=en
```

| Query | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `lang`      | `string` | **Required**. item key from available_languages from panel.php |



## Feedback

If you have any feedback, please reach out to us at vwaaala@gmail.com

