<x-layout>
    <main class=" container mx-auto flex-grow my-10">
        <form action="{{ $action }}" method="post" enctype='multipart/form-data'>
            @csrf <!-- {{ csrf_field() }} -->
            @method($method)
            <div class=" grid grid-cols-6 gap-6">
                <div>
                    @if (isset($work))
                        <img
                            class='rounded aspect-[5/7] object-cover bg-no-repeat bg-center'
                            src="{{$work->image_url}}" alt="image"
                        >
                    @endif
                    <x-form.input type="file" name="image" class="w-full" />
                </div>
                <div class=" col-span-5 font-semibold">
                    <h1>
                        <x-form.input placeholder="Название" type="text" name="ru_name" value="{{isset($work) ? $work->ru_name : null}}" class=" text-3xl w-full" />
                        <x-form.input placeholder="Название" type="text" name="name" value="{{isset($work) ? $work->name : null}}" class=" w-full text-xl" />
                    </h1>
                    <div class="grid grid-cols-2 my-4">
                        <div class=" grid grid-cols-2 gap-2">
                            <div>Тип:</div>
                            <x-form.select name="type_id">
                                @foreach ($types as $el)
                                    <option value="{{$el->id}}" @selected(isset($works) ? $work->type->id == $el->id : null)>{{$el->ru_name}}</option>
                                @endforeach
                            </x-form.select>
                            <div>Статус:</div>
                            <x-form.select name="status_id">
                                @foreach ($statuses as $el)
                                    <option value="{{$el->id}}" @selected(isset($works) ? $work->status->id == $el->id : null)>{{$el->ru_name}}</option>
                                @endforeach
                            </x-form.select>
                            <div>Студия:</div>
                            <x-form.select name="company_id">
                                @foreach ($companies as $el)
                                    <option value="{{$el->id}}" @selected(isset($works) ? $work->company->id == $el->id : null)>{{$el->name}}</option>
                                @endforeach
                            </x-form.select>
                            
                        </div>
                    </div>
                    <div class=" overflow-y-scroll w-96 h-36 border-2 grid gap-2 p-2">
                        <div>Жанры:</div>
                        @foreach ($genres as $genre)
                            <div>
                                <input type="checkbox" name="genres[]" id="{{$genre->name}}" value="{{ $genre->id }}" @checked(isset($work) ? in_array($genre->id , collect($work->genres)->pluck('id')->all()) : false) />
                                <label for="{{$genre->name}}">{{$genre->ru_name}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class=" my-10">
                <x-form.textarea class=" w-full" rows="5" name="description">{{isset($work) ? $work->description : null}}</x-form.textarea>
            </div>
            <div class=" my-10 flex gap-4">
                @if (isset($work->parent_work))
                    <x-card.x 
                        :href="'/public/anime/'.$work->parent_work->name"
                        :image="substr($work->parent_work->image, 7)"
                        :name="$work->parent_work->ru_name"
                        :type="$work->parent_work->type->ru_name"
                        :relatation="'Предыстория'"
                    />
                @endif
                @if (isset($work->child_work))
                    <x-card.x 
                        :href="'/public/anime/'.$work->child_work['name']"
                        :image="substr($work->child_work['image'], 7)"
                        :name="$work->child_work['ru_name']"
                        :type="$work->child_work['type']->ru_name"
                        :relatation="'Продолжение'"
                    />
                @endif
            </div>
            <div class=" my-2">
                <x-form.input class="w-full" type="text" name="parent_work_name" placeholder="Имя предыстории" value="{{$work->parent_work->name ?? ''}}" />
            </div>
            <button type="submit" class=" border-2 p-2">Сохранить</button>
            <a href="{{isset($work) ? route('anime.show', $work->name) : route('anime.filter')}}"><button type="button" class=" border-2 p-2">Выйти</button></a>
        </form>

    </main>
</x-layout>