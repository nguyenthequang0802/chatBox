<div class="hidden" id="addNewRoomFormModal">
    <div class="absolute top-0 left-0 h-screen w-full opacity-50 bg-black">
    </div>
    <div class="absolute top-0 left-0 h-screen w-full flex justify-center">
        <div class=" w-1/3 self-center p-4 relative">
            <div class="w-full h-full  bg-white rounded-lg">
                <form id="createRoomForm" class="py-6 px-8" method="POST">
                    @csrf
                    <!-- Form Title -->
                    <h3 class="text-2xl text-center font-bold pb-4 text-gray-700">Create new Form</h3>
                    <!-- Room Name -->
                    <div class="w-full">
                        <label for="room_name" class="font-lg font-semibold text-gray-600">Room Name: </label>   <br>
                        <input type="text" name="room_name" id="room_name" required
                               placeholder="Type room name"
                               class="w-full py-1.5 px-4 border border-gray-400 rounded-lg mt-1 focus:outline-blue-600"
                               autofocus
                        />
                    </div>
                    <!-- Room Icon -->
                    <div class="w-full mt-3">
                        <label for="room_icon" class="font-lg font-semibold text-gray-600">Room Icon: </label>   <br>
                        <input type="text" name="room_icon" id="room_icon"
                               placeholder="Type room name"
                               class="w-full py-1.5 px-4 border border-gray-400 rounded-lg mt-1 focus:outline-blue-600"
                               autofocus
                        />
                    </div>

                    <!-- Room Description -->
                    <div class="w-full mt-3">
                        <label for="room_description" class="font-lg font-semibold text-gray-600">Room Description: </label>   <br>
                        <textarea type="text" name="room_description" id="room_description"
                                  placeholder="Type room name"
                                  class="w-full py-1.5 px-4 border border-gray-400 rounded-lg mt-1 focus:outline-blue-600"
                                  rows="3"
                                  autofocus
                        ></textarea>
                    </div>

                    <!-- Submit button -->
                    <div class="w-full mt-3 ">
                        <div class="flex justify-end items-center gap-2">
                            <button type="button" onclick="closeModal('addNewRoomFormModal')" class="bg-gray-500 border border-gray-500 text-white py-2 px-4 rounded-lg hover:bg-white hover:text-gray-500 ">
                                Cancel
                            </button>
                            <button type="submit" class="bg-blue-500 border border-blue-500 text-white py-2 px-4 rounded-lg hover:bg-white hover:text-blue-600">
                                Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <button type="button" onclick="closeModal('addNewRoomFormModal')"
                    class="absolute top-0 right-0 border border-gray-300 bg-gray-300 w-8 h-8 rounded-full text-red-500 hover:text-white hover:bg-red-500 hover:border-red-500">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(e){
        $('#createRoomForm').submit(function (e){
            e.preventDefault();
            console.log("Form submit");
            $.ajax({
                type: 'POST',
                url: '{{ route("room.store") }}',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    if(response.icon === null){
                        response.icon = 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg';
                    }
                    if(response.description === null){
                        response.description = '';
                    }
                    let html = '';
                    html += `
                    <a href="#" class="w-full bg-[#262948] hover:bg-[#4289f3] py-3 px-4 my-4 rounded-lg grid grid-cols-3 gap-2 relative">
                            <div class="col-span-1">
                                <div class="flex justify-start items-center gap-4">
                                    <div class="w-8 h-8 rounded-full">
                                        <img src="${response.icon}" alt="avatar" class="w-full h-full rounded-full border-2 border-red-500" />
                                    </div>
                                    <p class="font-bold">${response.name}</p>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <p>${response.description}</p>
                            </div>
                        </a>`;
                    console.log(html);
                    $('#rooms_list').prepend(html);
                    closeModal('addNewRoomFormModal');
                },
                error: function (error){
                    console.log(error);
                    closeModal('addNewRoomFormModal');
                },
            });
            $('#createRoomForm')[0].reset();
        });
    })
</script>
