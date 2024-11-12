@props([
    'select2' => false,
    'datepicker' => false,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Untitled' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    <!-- Scripts -->

    @if ($select2)
        <link rel="stylesheet" href="{{asset('css/select2.css')}}">
    @endif

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sarabun antialiased">
    <div
        x-data="mainState"
        :class="{ dark: isDarkMode }"
        x-on:resize.window="handleWindowResize"
        x-cloak
    >
        <div class="min-h-screen text-gray-900 bg-gray-100 dark:bg-dark-eval-0 dark:text-gray-200">
            <!-- Sidebar -->
            <x-sidebar.sidebar />

            <!-- Page Wrapper -->
            <div
                class="flex flex-col min-h-screen"
                :class="{
                    'lg:ml-64': isSidebarOpen,
                    'md:ml-16': !isSidebarOpen
                }"
                style="transition-property: margin; transition-duration: 150ms;"
            >

                <!-- Navbar -->
                <x-navbar />

                <!-- Page Heading -->
                <header>
                    <div class="p-4 sm:p-6">
                        {{ $header ?? "" }}
                    </div>
                </header>

                <!-- Page Content -->
                <main class="px-4 sm:px-6 flex-1 ">
                    {{ $slot }}
                </main>

                <!-- Page Footer -->
                <x-footer />
            </div>
            <div id="teleport-wrapper"></div>
        </div>

        <script src="{{asset('js/jquery.min.js')}}"></script>
        @isset($scripts)
            {{$scripts}}
        @endisset
        @if ($select2)
            <script src="{{asset('js/select2.min.js')}}"></script>
        @endif
        @if ($datepicker)
            <script src="{{asset('js/datepicker.js')}}"></script>
            <script src="{{asset('js/datepicker.th.js')}}"></script>
            <script src="{{asset('js/moment.js')}}"></script>
            <script>
                flatpickr.localize(flatpickr.l10ns.th);
                moment.locale('th');
            </script>
        @endif
    </div>

    @livewireScripts
    <script>
        Livewire.directive('confirmation', ({ el, directive, component, cleanup }) => {
            let content =  directive.expression


            const closeDropdown = () => el.dispatchEvent(new CustomEvent("close-dropdown", {
                bubbles: true,
                composed: true,
            }));

            const showConfirmation = (data) => {
                return new Promise((resolve, reject) => {
                    const event = new CustomEvent("confirmation", {
                        detail: {
                            ...data,
                            confirm: () => {
                                resolve();
                            },
                            cancel: () => {
                                reject();
                            }
                        },
                        bubbles: true,
                        composed: true,
                    });

                    el.dispatchEvent(event);
                });
            }

            let onClick = async e => {
                e.stopImmediatePropagation()
                e.preventDefault()

                try {
                    const result = content.match(/^(?<variant>\w+)?(?:\:\[(?<title>[^\]]+)\])?(?<text>.*)$/);
                    const variant = result && result.groups ? (result.groups.variant || "primary") : "primary";
                    const title = result && result.groups ? (result.groups.title || null) : null;
                    const text = result && result.groups ? (result.groups.text || null) : null;
                    closeDropdown()
                    await showConfirmation({variant, title, text})
                    el.removeEventListener('click', onClick, { capture: true })
                    el.click();
                    el.addEventListener('click', onClick, { capture: true })
                } catch (error) {
                    // on cancel
                }
            }

            el.addEventListener('click', onClick, { capture: true })

            cleanup(() => {
                el.removeEventListener('click', onClick)
            })
        })
    </script>
</body>
</html>
