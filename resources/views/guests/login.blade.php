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
        <title>{{ config('app.name', 'Laravel') }}</title>
    </head>

    <body>
        <form method="POST">
            @csrf
            <input
                type="text"
                name="key"
                placeholder="key"
            >
            <button type="submit">
                Valider
            </button>
        </form>
    </body>

</html>
