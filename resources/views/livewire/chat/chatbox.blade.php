<div class="hidden lg:col-span-2 lg:block" id="chat-box">
    @if($selectedConversation)
    <div class="w-full flex flex-col h-full">
        <div class="flex items-center justify-between p-3 border-b border-gray-300">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                     id="btn-return"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </div>
            <div class="relative flex items-center">
                <span class="block mr-2 font-bold text-gray-600">{{ $selectedConversation->user_instance->name }}</span>
                <img class="object-cover w-10 h-10 rounded-full"
                     src="{{ $selectedConversation->user_instance->avatar_holder }}"
                     alt="{{ $selectedConversation->user_instance->name }}"/>
                <span class="absolute w-3 h-3 bg-green-600 rounded-full right-5 -top-1"></span>
            </div>
        </div>
        <div class="relative w-full p-6 overflow-y-auto" style="height: calc(100vh - 65px - 65px - 70px)" id="chat-body">
            <ul class="space-y-2">
                @php($authId = auth()->id())
                @forelse($messages as $message)
                    @if($message->sender_id == $authId)
                        <li wire:key="{{$message->id}}" class="flex justify-end">
                            <div class="relative max-w-xl px-4 py-2 text-gray-700 bg-gray-100 rounded shadow">
                                <span class="block">{!! $message->body !!}</span>
                            </div>
                        </li>
                    @else
                        <li wire:key="{{$message->id}}" class="flex justify-start">
                            <div class="relative max-w-xl px-4 py-2 text-gray-700 rounded shadow">
                                <span class="block">{!! $message->body !!}</span>
                            </div>
                        </li>
                    @endif
                @empty
                    <li>no msg</li>
                @endforelse
            </ul>
        </div>
        <livewire:chat.send-message :conversation="$selectedConversation"/>
    </div>
        <script>
            let chatBody = document.querySelector('#chat-body')

            document.querySelector('#btn-return').addEventListener('click', evt => {
                document.getElementById('chat-list').classList.remove('hidden');
                document.getElementById('chat-box').classList.add('hidden');
            })
            window.addEventListener('chatSelected', evt => {
                chatBody.scrollTop = chatBody.scrollHeight
            })
            window.addEventListener('addRowMessage', evt => {
                chatBody.scrollTop = chatBody.scrollHeight
            })
            chatBody.addEventListener('scroll', evt => {
                let old = JSON.parse(JSON.stringify(chatBody.scrollTop))
                if(chatBody.scrollTop < 100){
                    chatBody.scrollTop -= old
                    window.livewire.emit('loadMoreMessage')
                }
            })
        </script>
    @else
        <div class="flex items-center justify-center h-full">
            not selected conversation
        </div>
    @endif
</div>

