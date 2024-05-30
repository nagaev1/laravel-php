<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body class=' min-h-svh flex flex-col justify-between'>
    <nav class='h-20 bg-black'>
        <div class=" h-full grid place-items-center">
            <form method="GET" action="/public/anime">
                <x-form.input type="search" name="q" />
                <button type="submit" class="text-white">поиск</button>
            </form>
        </div>
    </nav>
    {{$slot}}
    <footer class='h-20 bg-black text-white'>
        footer
    </footer>
</body>
</html>