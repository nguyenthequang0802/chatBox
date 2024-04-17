@extends('Layout.index')
@section('content')
    <div class="col-span-2 h-full bg-[#202441] text-white text-base w-full pl-12 pr-12 py-8">
        <div class="font-bold  text-3xl flex justify-between">
            <div class="flex justify-start items-center gap-4">
                <i class="fa-solid fa-users"></i>
                <p> Chat Room</p>
            </div>
            <div class="flex justify-start items-center gap-4">
                <button type="button" onclick="openModal('searchRoomModal')" class="text-white hover:text-orange-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <button type="button" onclick="openModal('addNewRoomFormModal')" class="text-white hover:text-orange-400">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="w-full pl-4 mt-12">
            <p class="font-semibold">My rooms</p>

            <div class="w-full" id="rooms_list">
                @foreach($rooms as $room)
                    <a href="#" class="w-full bg-[#262948] hover:bg-[#4289f3] py-3 px-4 my-4 rounded-lg grid grid-cols-3 gap-2 relative" id="Room-{{ $room->id }}" onclick="showRoom('{{ $room->id }}')">
                        <div class="col-span-1">
                            <div class="flex justify-start items-center gap-4">
                                <div class="w-8 h-8 rounded-full">
                                    @include('components.avatar', ['avatar_path' => $room->icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                                </div>
                                <p class="font-bold">{{$room->name}}</p>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <p> {{$room->description}}</p>
                        </div>
                        <div class="absolute top-0 right-0 text-sm mr-2 mt-1  flex justify-end items-center gap-4">
                            <p class="text-gray-400">2 min ago</p>
                            @include('components.countNotification', ['number' => 1])
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="w-full pl-4 mt-12">
            <p class="font-semibold">Joined rooms</p>

            <div class="w-full" id="joined_rooms_list">
                @foreach($joined_rooms as $room)
                    <a href="#" class="w-full bg-[#262948] hover:bg-[#4289f3] py-3 px-4 my-4 rounded-lg grid grid-cols-3 gap-2 relative" id="Room-{{ $room->id }}" onclick="showRoom('{{ $room->id }}')">
                        <div class="col-span-1">
                            <div class="flex justify-start items-center gap-4">
                                <div class="w-8 h-8 rounded-full">
                                    @include('components.avatar', ['avatar_path' => $room->icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                                </div>
                                <p class="font-bold">{{$room->name}}</p>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <p> {{$room->description}}</p>
                        </div>
                        <div class="absolute top-0 right-0 text-sm mr-2 mt-1  flex justify-end items-center gap-4">
                            <p class="text-gray-400">2 min ago</p>
                            @include('components.countNotification', ['number' => 1])
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
    {{--            column-2--}}
    <div class="col-span-1 w-full h-full bg-[#212540] px-4" id="column_detail_room">
        <div id="InfoRoom" class="">
            <div id="TagNameOfRoom">

            </div>

            <div class="h-[85vh] px-8 bg-[#262948] mt-4 pt-5 rounded-lg overflow-auto" id="TagListMember">
                {{--Show list members--}}
            </div>
        </div>
    </div>
@include('components.modals.createFormModal')
@include('components.modals.searchRoomModal')
@include('components.modals.notification')
    @include('components.modals.notificationMess')
    <script>
        function showRoom(room_id){
            $('#TagNameOfRoom').empty();
            $('#TagListMember').empty();
            $.ajax({
                type: 'GET',
                url: '{{ route("room.show") }}',
                data:{
                    _token: '{{ csrf_token() }}',
                    room_id: room_id
                },
                success: function (response){
                    console.log(response);
                    const info_room = response.infoRoom;
                    const list_members = response.listMembers;
                    let roomUrlTemplate="{{ route('room.boxChat', ['id' => 'ROOM_ID_PLACEHOLDER']) }}"
                    let roomUrl = roomUrlTemplate.replace('ROOM_ID_PLACEHOLDER', room_id);
                    console.log(roomUrl);
                    const infoNameHTML = `<div class="h-[15vh] bg-[#262948] mb-3 rounded-lg flex items-center p-[20px] justify-between" >
                                               <div class="flex flex-wrap items-center" id="Room-${info_room.id}">
                                                <div class="h-12 w-12">
                                                    <img src="${info_room.icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'}" alt="avatar" class="w-full h-full rounded-full border-2 border-red-500" />
                                                </div>
                                                <div class="grid grid-cols-1 p-2">
                                                    <div class="font-bold text-lg text-white pb-1">
                                                        <p>${ info_room.name }</p>
                                                    </div>
                                                    <div>
                                                        <sub class="text-gray-400">${list_members.length} Thành viên</sub>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex text-white text-lg">
                                                <a href="${roomUrl}" onclick="">
                                                    <button class="mr-[10px]">
                                                        <i class="fa-brands fa-facebook-messenger"></i>
                                                    </button>
                                                </a>
                                                <a href="">
                                                    <button>
                                                        <i class="fa-solid fa-right-from-bracket"></i>
                                                    </button>
                                                </a>
                                            </div>
                                          </div>
                                          <form id="searchMember-${info_room.id}">
                                            <div class="relative">
                                                <label>
                                                    <input type="text" class="w-full h-[40px] rounded-[5px] p-2" id="inputNameMember-${info_room.id}">
                                                    <button class="absolute right-[24px] text-lg pt-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                </label>
                                            </div>
                                        </form>`;
                    let listMemHTML = '';
                    for(let i = 0; i < list_members.length; i++) {
                        listMemHTML += `<div class="col-span-1 mb-5 w-full">
                                        <div class="h-[65px] bg-white flex rounded-lg">
                                            <div class="h-full p-2">
                                                <img src="${list_members[i].icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'}" alt="avatar" class="w-full h-full rounded-full border-2 border-red-500" />
                                            </div>
                                            <div class="grid grid-cols-1 p-4">
                                                <div class="font-bold text-lg text-gray-600 pb-1 ">
                                                    <p>${list_members[i].name}</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>`;
                    }
                    $('#TagNameOfRoom').html(infoNameHTML);
                    $('#TagListMember').html(listMemHTML);
                }
            })
        }
    </script>
@endsection
