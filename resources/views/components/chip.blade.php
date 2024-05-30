<!-- я нифига не понял почему я не могу обратьться на прямую -->


@if (isset($attributes['href']))
    <a 
    href={{$attributes['href']}}
    {{$attributes->merge(['class' => 'inline px-2 py-1 rounded-3xl bg-emerald-600 text-white text-center align-middle'])}}
    >
        {{$slot}}
    </a>
@else
    <div
    {{$attributes->merge(['class' => 'inline px-2 py-1 rounded-3xl bg-emerald-600 text-white text-center align-middle'])}}
    >
    {{$slot}}
    </div>
@endif