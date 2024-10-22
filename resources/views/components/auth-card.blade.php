@props([
    "title" => ""
])
<main class="flex flex-col items-center flex-1 px-4 pt-6 sm:justify-center">
    <div class="w-full px-6 py-4 my-6 overflow-hidden bg-white rounded-md shadow-md sm:max-w-md dark:bg-dark-eval-1">
        <div class="mb-6 flex gap-2 justify-start items-center">
            <a href="/">
                <x-application-logo class="w-10 h-10" />
            </a>
            <h1 class="text-lg">{{$title}}</h1>
        </div>
        {{ $slot }}
    </div>
</main>
