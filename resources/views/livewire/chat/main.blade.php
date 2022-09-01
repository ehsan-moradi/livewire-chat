<div class="container mx-auto bg-white">
    <div class="min-w-full border rounded lg:grid lg:grid-cols-3">
       <livewire:chat.chat-list/>
       <livewire:chat.chatbox/>
    </div>
    <script>
        window.addEventListener('chatSelected', evt => {
            if (window.innerWidth < 768){
                document.getElementById('chat-list').classList.add('hidden');
                document.getElementById('chat-box').classList.remove('hidden');
            }
        })
        window.addEventListener('resize', ev => {
            if (window.innerWidth > 768){
                document.getElementById('chat-list').classList.remove('hidden');
                document.getElementById('chat-box').classList.remove('hidden');
            }
        })
    </script>
</div>


