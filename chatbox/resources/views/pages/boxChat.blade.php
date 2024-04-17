@extends('Layout.index')
@section('content')
    <div class="col-span-2 h-full bg-[#202441] text-white text-base w-full pl-12 pr-12 py-8 ">
        <div class="h-[15vh] bg-[#262948] mb-3 rounded-lg flex items-center p-[20px] justify-between" >
            <div class="flex flex-wrap items-center" id="Room-{{ $room->id }}">
                <div class="h-12 w-12">
                    @include('components.avatar')
{{--                    <img src="${info_room.icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'}" alt="avatar" class="w-full h-full rounded-full border-2 border-red-500" />--}}
                </div>
                <div class="grid grid-cols-1 p-2">
                    <div class="font-bold text-lg text-white pb-1">
                        <p>{{ $room->name }}</p>
                    </div>
                    <div>
                        <sub class="text-gray-400">{{ $listMembers->count() }} Thành viên</sub>
                    </div>
                </div>
            </div>
            <div class="flex text-white text-lg">
                <a href="">
                    <button>
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </a>
            </div>
        </div>
        <div class="relative h-[75vh]">
            <div class="h-[88%] w-full mb-5 overflow-auto" id="boxChat">
                @foreach($messages as $message)
                    @if($message->user_id !== $me->id)
                        <div class="flex mb-3">
                            <div class="h-10 w-10 m-[10px]">
                                @include('components.avatar', ['avatar_path' => $room->icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                            </div>
                            <div class="bg-[#262948] rounded-lg p-2 text-white">
                                <p>{{ $message->content }}</p>
                                <small class="float-right">{{ $message->created_at }}</small>
                            </div>
                            <div class="text-white m-[5px]"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                        </div>
                    @else
                        <div class="flex flex-row-reverse mb-3">
                            <div class="h-10 w-10 m-[10px]">
                                @include('components.avatar', ['avatar_path' => $room->icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                            </div>
                            <div class="bg-[#262948] rounded-lg p-2 text-white">
                                <p>{{ $message->content }}</p>
                                <small class="float-left">{{ $message->created_at }}</small>
                            </div>
                            <div class="text-white m-[5px]"><i class="fa-solid fa-ellipsis-vertical"></i></div>

                        </div>
                    @endif
                @endforeach
            </div>
            <div id="form_mess" class="absolute w-full bottom-[20px]">
                <div class="h-[46px] bg-[#262948] rounded-lg flex justify-center items-center px-2 py-[4px]" id="message-${room.id}">
                    <input type="text" class="w-full h-full text-black px-2 bg-white rounded-full mr-2 content" name="content" id="content-{{ $room->id }}" >
                    <div class="mr-2">
                        <input type="file" class="hidden input_img" name="content_img" id="content_img" >
                        <button type="button" class="text-[20px] text-white btn-selectImage" id="" onclick="selectFile()" onchange="sendImage()"><i class="fa-solid fa-camera"></i></button>
                    </div>
                    <button class="text-[20px] mr-2 text-white" id="btn_sendMessage" onclick="sendMessage({{ $room->id }})"><i class="fa-solid fa-paper-plane"></i></button>
                </div>
                <div  class="absolute bottom-12 left-10">
                    <div class="bg-white h-auto rounded-lg overflow-y-scroll" id="tagName">

                    </div>
                </div>
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
    <script>
        let roomID = {{ $room->id }};
        const listMessage = document.getElementById('boxChat')
        Pusher.logToConsole = true;

        var pusher = new Pusher('3de20a79a40ba2abe378', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('channel-' + roomID);
        document.addEventListener('DOMContentLoaded', function (){
            listMessage.scrollTo(0,  listMessage.scrollHeight);
            channel.bind('my-event', function(data) {
                console.log(data);
                if( {{ Auth::user()->id }} != data.message.user_id){
                    listMessage.scrollTo(0,  listMessage.scrollHeight);
                    const html = `<div class="flex mb-3">
                                            <div class="h-10 w-10 m-[10px]">
                                                @include('components.avatar', ['avatar_path' => $room->icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                    </div>
                    <div class="bg-[#262948] rounded-lg p-2 text-white">
                        <p>${data.message.content}</p>

                                            </div>
                                            <div class="text-white m-[5px]"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                                        </div>`;
                    $('#boxChat').append(html);
                }
            });
        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function sendMessage(room_id){
            let content = $('.content').val();
            $.ajax({
                type: 'POST',
                url: '{{ route("room.sendMess") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    room_id: room_id,
                    content: content,
                    type: 'text',
                    user_id: {{ \Illuminate\Support\Facades\Auth::user()->id }}
                },
                success: function (response) {
                    console.log(response);
                    let time = new Date(response.created_at);
                    let hours = time.getHours();
                    let minutes = time.getMinutes();
                    const html = `<div class="flex flex-row-reverse mb-3">
                                <div class="h-10 w-10 m-[10px]">
                                    @include('components.avatar', ['avatar_path' => $room->icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                    </div>
                    <div class="bg-[#262948] rounded-lg p-2 text-white">
                        <p>${response.content}</p>
                                    <small class="float-left">${hours}:${minutes}</small>
                                </div>
                                <div class="text-white m-[5px]"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                            </div>`;
                    $('#boxChat').append(html);
                    $('.content').val('');
                },
            });
        }
        function selectFile(){
            $('#content_img').click();
        }
        function sendImage(){
            {{--const file_data = $('#content_img').prop('files')[0];--}}
            {{--const room_id = {{ $room->id }};--}}
            {{--const data = new FormData();--}}
            {{--data.append('content_img', file_data);--}}
            {{--// data.append('_token',$('meta[name="csrf-token"]').attr('content_img'));--}}
            {{--data.append('room_id', room_id);--}}
            {{--console.log(data);--}}
            {{--$.ajax({--}}
            {{--    type: 'POST',--}}
            {{--    url: '{{ route('room.sendImage') }}',--}}
            {{--    data: data,--}}
            {{--    processData: false,--}}
            {{--    contentType: false,--}}
            {{--    success: function (response){--}}
            {{--        console.log(response);--}}
            {{--    }--}}
            {{--})--}}
        }
        const listMembers = @json($listMembers);
        document.addEventListener('DOMContentLoaded', function(){
            const input = document.getElementById('content-{{ $room->id }}');
            const membersBox = document.getElementById('tagName')
            input.addEventListener('input', function (e){
                const value = e.target.value;
                const cusorPos = e.target.selectionStart;
                const lastAtPos = value.lastIndexOf('@', cusorPos-1);
                const nextSpacePos = value.indexOf(' ', lastAtPos + 1) > -1 ? value.indexOf(' ', lastAtPos + 1) : value.length;
                if(checkSpace(value)){
                    membersBox.style.display = 'none';
                    return 0;
                } else {
                    if (lastAtPos > -1){
                        const searchStr = value.substring(lastAtPos + 1, nextSpacePos).trim();
                        if (searchStr.length > 0){
                            const result = listMembers.filter(user => user.name.toLowerCase().includes(searchStr.toLowerCase()));
                            console.log(result);
                            membersBox.style.display = 'block';
                            membersBox.innerHTML = result.map(user => `<div class=" pb-1 m-1" >
                            <p class="search-result-item text-[#505050]" data-name="@${user.name}">${user.name}</p>
                        </div>`).join();
                            positionResultBox(membersBox, input);
                        }else {
                            membersBox.style.display = 'none';
                        }
                    } else {
                        membersBox.style.display = 'none';
                    }
                }
            });
            function  positionResultBox(box, inputElement){
                const rect = inputElement.getBoundingClientRect();
            }
            function checkSpace(str){
                let firstQuoteIndex = str.indexOf(' ');
                if(firstQuoteIndex === -1){
                    return false;
                }
                return  true;
            }
            membersBox.addEventListener('click', function (e){
                console.log("clicked")
                if(e.target.classList.contains('search-result-item')){
                    const selectedName = e.target.dataset.name;
                    const value = input.value;
                    const lastAtPos = value.lastIndexOf('@');
                    const nextSpacePos = value.indexOf(' ', lastAtPos+1) > -1 ? value.indexOf(' ', lastAtPos + 1) : value.length;
                    input.value = value.substring(0, lastAtPos) + selectedName + value.substring(nextSpacePos);

                    membersBox.style.display = 'none';
                }
            });
        });
    </script>
@endsection
