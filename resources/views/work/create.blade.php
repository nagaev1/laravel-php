<x-layout>
    <main>
        <section class="container mx-auto my-8">
            <form action="{{ route('anime.store') }}" method="post" enctype='multipart/form-data' class=" w-[30rem] max-w-full mx-auto grid gap-4">
                @csrf <!-- {{ csrf_field() }} -->
                <x-form.input type="text" placeholder="Оригинальное название" name="name" />
                <x-form.input type="text" placeholder="Название на русском" name="ru_name" />
                <x-form.textarea name="description" placeholder="Описание" rows="4" />
                <x-form.select name="status_id">
                    <option selected disabled>Cтатус</option>
                    @foreach ($statuses as $el)
                        <option value="{{$el->id}}">{{$el->ru_name}}</option>
                    @endforeach
                </x-form.select>
                <x-form.select name="type_id">
                    <option selected disabled>Тип</option>
                    @foreach ($types as $el)
                        <option value="{{$el->id}}">{{$el->ru_name}}</option>
                    @endforeach
                </x-form.select>
                <x-form.select name="company_id">
                    <option selected disabled>Студия</option>
                    @foreach ($companies as $el)
                        <option value="{{$el->id}}">{{$el->name}}</option>
                    @endforeach
                </x-form.select>
                <div class=" overflow-y-scroll h-40 border-2 grid gap-2 p-2">
                    <div>Жанры</div>
                    @foreach ($genres as $genre)
                        <div class="">
                            <input type="checkbox" name="genres[]" id="{{$genre->name}}" value="{{ $genre->id }}" />
                            <label for="{{$genre->name}}">{{$genre->ru_name}}</label>
                        </div>
                    @endforeach
                </div>
                <x-form.input type="file" name="image" />
                <button type="submit" class=" border-2 p-2">Создать</button>
            </form>
        </section>
    </main>
</x-layout>