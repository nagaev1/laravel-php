<a href={{ $href ??= "#" }}>
    <div
        {{$attributes->merge(['class' => ' w-80 rounded aspect-[5/2] grid grid-cols-3 items-center'])}}
    >
        <img src="{{ base_path().'storage/'.($image ??= null) }}" alt="img" class=" rounded-lg col-span-1">

        <div class=" col-span-2 p-2 break-words self-center flex flex-col justify-between h-full">
            <div>
                {{$name ??= null}}
            </div>
            <div class=" flex justify-between">
                <div>
                    {{$type ?? ""}}
                </div>
                <div>
                    {{$relatation ?? ""}}
                </div>
            </div>
        </div>
    
    </div>
</a>