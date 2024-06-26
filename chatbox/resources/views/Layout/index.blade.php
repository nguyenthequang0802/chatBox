<!doctype html>
<html>
@include('partials.Head')
<body>
<!-- Main navigation container -->
<div class="app h-screen w-full grid grid-cols-6 text-base">
    <div class="col-span-1 w-full h-full bg-[#262948]">
        <div class="w-full py-8 px-4">
            <div class="flex justify-start items-center gap-4">
                <div class="w-12 h-12 rounded-full">
                    @include('components.avatar', ['avatar_path' => 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                </div>
                <div class="font-bold text-lg text-white">
                    @guest()
                        <p>Guest</p>
                    @else
                        <p>{{ Auth::user()->name }}</p>
                    @endguest
                </div>
            </div>
        </div>

        <div class="w-full py-4 px-6 text-white font-semibold">
            <div class="flex justify-between items-center py-2">
                <a class="flex justify-start items-center gap-4" href="">
                    <i class="fa-solid fa-house"></i>
                    <p>Dashboard</p>
                </a>
                @include('components.countNotification', ['number' => 1])
            </div>
            <div class="flex justify-between items-center py-2">
                <a class="flex justify-start items-center gap-4" href="">
                    <i class="fa-solid fa-users"></i>
                    <p>Chat Room</p>
                </a>
                @include('components.countNotification', ['number' => 2])
            </div>
            <div class="flex justify-between items-center py-2">
                <a class="flex justify-start items-center gap-4" href="">
                    <i class="fa-solid fa-calendar-days"></i>
                    <p>Calendar</p>
                </a>
                @include('components.countNotification', ['number' => 1])
            </div>
        </div>
        <div class="w-full absolute bottom-0 py-8 px-6 text-white font-semibold">
            <a href="#" class="flex justify-start items-center gap-4 py-2 hover:text-red-400">
                <i class="fa-solid fa-gear"></i>
                <p>Setting</p>
            </a>
            <a href="{{ route('logout') }}" class="flex justify-start items-center gap-4 py-2 hover:text-red-500"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket"></i>
                <p> Logout</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <div class="col-span-5 w-full h-full bg-blue-200 gap-1">
        <div class="grid grid-cols-3 gap-1 h-full">
            {{--            column 1--}}
            @yield('content')
        </div>
    </div>
</div>
@include('partials.javascript')
</body>
</html>
