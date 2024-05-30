@php

    $info = [
        [
            'property' => 'types',
            'value' => $work->type->name,
            'ru_property' => 'Тип',
            'ru_value' => $work->type->ru_name
        ],
        [
            'property' => 'statuses',
            'value' => $work->status->name,
            'ru_property' => 'Статус',
            'ru_value' => $work->status->ru_name
        ],
        [
            'property' => 'studios',
            'value' => $work->company->name,
            'ru_property' => 'Студия',
            'ru_value' => $work->company->name
        ],
    ];

@endphp

<x-layout>
    <main class=" container mx-auto flex-grow my-10">
        <div class=" grid grid-cols-6 gap-6">
            <img
                class='rounded aspect-[5/7] object-cover bg-no-repeat bg-center'
                src='{{$work->image_url}}' alt="image"
            >
            <div class=" col-span-5 font-semibold">
                <h1 class=" text-3xl">
                    {{$work->ru_name}}
                </h1>
                <div class="grid grid-cols-2 my-4">
                    <div class=" grid grid-cols-2 gap-2">
                        @foreach ($info as $el)
                            <div>
                                {{$el['ru_property']}}:
                            </div>
                            <a href="{{ route('anime.filter', [ $el['property'].'[]' => $el['value'] ]) }}">
                                {{$el['ru_value']}}
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="flex gap-2">
                    @foreach ($work->genres as $genre)
                        <x-chip :href="route('anime.filter', [ 'genres[]' => $genre->name ])">
                            {{$genre->ru_name}}
                        </x-chip>
                    @endforeach
                </div>
            </div>
        </div>
        <div class=" my-10">
            {{$work->description}}
        </div>
        <div class=" my-10 flex gap-4">
            @if (isset($work->parent_work))
                <x-card.x 
                    :href="route('anime.show', $work->parent_work->name)"
                    :image="substr($work->parent_work->image, 7)"
                    :name="$work->parent_work->ru_name"
                    :type="$work->parent_work->type->ru_name"
                    :relatation="'Предыстория'"
                />
            @endif
            @if (isset($work->child_work))
                <x-card.x 
                    :href=" route('anime.show', $work->child_work['name'])"
                    :image="substr($work->child_work['image'], 7)"
                    :name="$work->child_work['ru_name']"
                    :type="$work->child_work['type']->ru_name"
                    :relatation="'Продолжение'"
                />
            @endif
        </div>
        <a href="{{route('anime.edit', $work->name)}}">Редактировать</a>

    </main>
</x-layout>