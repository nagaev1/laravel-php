<a href={{ $href ??= "#" }}>
    <div
        {{
            $attributes->merge(['class' => 'rounded aspect-[5/7] bg-cover bg-no-repeat bg-center'])
        }}
        style='background-image: url({{$image ??= null}}); '>
    
        <div class=" rounded p-2 text-white flex flex-col-reverse h-full bg-gradient-to-b from-transparent via-transparent to-black">
            {{$name ??= null}}
        </div>
    
    </div>
</a>