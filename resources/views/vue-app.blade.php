<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="dark"
>

    <head>
        <meta charset="utf-8">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, maximum-scale=1,  user-scalable=0"
        >

        <link
            rel="icon"
            href="{{ asset('favicon.svg') }}"
            type="image/svg+xml"
        >

        <title>{{ config('app.name', 'Laravel') }}</title>

        <style type="text/css">
            :root.dark {
                color-scheme: dark;
            }
        </style>

        @routes()

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite('vue-app/main.js')
        @endif
    </head>

    <body
        data-app-version="{{ config('app.version') }}"
        data-app-name="{{ config('app.name') }}"
        data-user="{{ json_encode(auth()->user()) }}"
        data-master-client-id="{{ cache('master-client-id') }}"
        data-articles="{{ json_encode(App\Models\Article::all()) }}"
        data-stripe-pk="{{ config('services.stripe.pk') }}"
        data-pusher-key="{{ config('broadcasting.connections.pusher.key') }}"
        data-translations="{{ json_encode(App\Tools\Translations::all()) }}"
        data-twint-payment-link="{{ config('services.twint.payment_link') }}"
    >
        <div id="app"></div>
    </body>

</html>
