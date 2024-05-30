<x-layout>
  <main class="text-xl flex-grow">
    <section class="container mx-auto my-8">
      <div class=" grid grid-cols-6">
        <img class="aspect[5/7]" src="{{url('storage', 'no-image.png')}}" alt="logo">
        <div class=" col-span-5">
          <span class=" text-3xl">
            {{$company->name}}
          </span>
          <p>{{$company->description}}</p>
        </div>
      </div>
      <div class=" grid grid-cols-6 gap-4">
        @foreach($works as $work)
          <x-card.y :name="$work->ru_name" :href="url('anime', $work->name)" :image="$work->image_url" />
        @endforeach
      </div>
    </section>
  </main>
</x-layout>