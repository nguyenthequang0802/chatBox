<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function openModal(modal_id){
        let addNewRoomFormModal =  document.getElementById(modal_id);
        addNewRoomFormModal.classList.remove('hidden');
        addNewRoomFormModal.classList.add('visible');
    }
    function closeModal(modal_id){
        let addNewRoomFormModal = document.getElementById(modal_id);
        addNewRoomFormModal.classList.remove('visible');
        addNewRoomFormModal.classList.add('hidden');
    }
    function turnOnNotifications(message, type){
        const notificationElement = document.getElementById('notification-'+type);
        const notificationMessageElement = document.getElementById('notification-'+type+'-message');
        notificationMessageElement.innerText = message;
        notificationElement.classList.remove('hidden');
        notificationElement.classList.add('visible');
        setTimeout(function (){
            notificationElement.classList.remove('visible');
            notificationElement.classList.add('hidden');
        }, 3000);
    }
</script>
