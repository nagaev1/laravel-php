<x-layout>
<main class="text-xl flex-grow">
    <section class="container mx-auto my-8">
      <form action="{{ $action }}" method="post">
        @csrf <!-- {{ csrf_field() }} -->
        @method($method)
        <div class=" grid grid-cols-6">
          <img class="aspect[5/7]" src="{{url('storage', 'no-image.png')}}" alt="logo">
          <div class=" col-span-5">
            <x-form.input class="block w-full text-3xl" placeholder="Название" name="name" value="{{ isset($company) ? $company->name : null }}"/>
            <x-form.textarea class="mt-4 w-full" placeholder="Описание" name="description">
              {{ isset($company) ? $company->description : null}}
            </x-form.textarea>
          </div>
        </div>
        <div class="text-end">
          <button type="submit" class="border-2 p-2">Сохранить</button>
        </div>
      </form>
    </section>
</main>
</x-layout>