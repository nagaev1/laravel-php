<x-layout>
  <main class="text-xl flex-grow">
    <section class=" container mx-auto my-10 grid grid-cols-5 gap-4">
      <div class=" col-span-4">
        <div class="grid gap-16">

          @if (sizeof($works) > 0)
          <div class=" grid grid-cols-5 gap-4 justify-center">
                <div class=" text-3xl col-span-5 flex justify-center">Аниме</div>
                @foreach($works as $el)
                    <x-card.y :name='$el->ru_name' :image='$el->image_url' :href="route('anime.show', $el->name)" />
                @endforeach
              </div>
          @else
            <div class=" text-3xl text-center">Аниме: Ничего не найдено</div>
          @endif

          @if (sizeof($companies) > 0)
          <h1 class=" text-3xl text-center">Студии</h1>
          <div class=" grid grid-cols-5 gap-4">
            @foreach ($companies as $company)
              <x-card.y :name='$company->name' :image="url('storage', 'no-image.png')" :href="route('company.show', $company->name)" />
            @endforeach
          </div>            
          @endif

        </div>
        
      </div>

      <!-- Боковая панель -->
      <div class="bg-slate-200 rounded-lg">
        <form method="GET" action="{{route('anime.filter')}}">

          <h2 class=" text-center">Жанры</h2>
          <div class=" p-3 grid gap-2 h-40 items-center overflow-y-scroll">
              @foreach ($genres as $genre)
                <div>
                  <input type="checkbox" name="genres[]" value="{{$genre->name}}" id="{{$genre->name}}">
                  <label for="{{$genre->name}}" class=" w-full">
                    {{$genre->ru_name}}
                  </label>
                </div>
              @endforeach
          </div>

          <h2 class="text-center">Статус</h2>
          <div class=" p-3 items-center grid gap-2">
              @foreach ($statuses as $status)
                <div>
                  <input type="checkbox" name="statuses[]" value="{{$status->name}}" id="{{$status->name}}">
                  <label for="{{$status->name}}" class=" w-full">
                    {{$status->ru_name}}
                  </label>
                </div>
              @endforeach
          </div>

          <h2 class="text-center">Тип</h2>
          <div class=" p-3 items-center grid gap-2">
              @foreach ($types as $type)
                <div>
                  <input type="checkbox" name="types[]" value="{{$type->name}}" id="{{$type->name}}">
                  <label for="{{$type->name}}" class=" w-full">
                    {{$type->ru_name}}
                  </label>
                </div>
              @endforeach
          </div>


          <button type="submit" class=" bg-rose-400 rounded-xl w-full text-white">Поиск</button>
        </form>
      </div>
    </section>

  </main>
</x-layout>
