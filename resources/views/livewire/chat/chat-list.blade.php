<div class="border-r border-gray-300 lg:col-span-1 relative" id="chat-list">
    <div class="my-3">
        <livewire:chat.search-box/>
    </div>
    <ul class="overflow-auto h-[32rem]">
        <h2 class="my-2 mb-2 ml-2 text-lg text-gray-600">Chats</h2>
        @forelse($conversations as $conversation)
        <li wire:click="$emitSelf('chatUserSelected', {{ $conversation }})" wire:key="{{ $conversation->id }}">
            <a class="flex items-center px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 focus:outline-none">
                <img class="object-cover w-10 h-10 rounded-full"
                     src="{{ $conversation->user->avatar_holder }}"
                     alt="{{ $conversation->userInstance->name }}"/>
                <div class="w-full pb-2">
                    <div class="flex justify-between">
                        <span class="block ml-2 font-semibold text-gray-600">{{ $conversation->userInstance->name }}</span>
                        <span class="block ml-2 text-sm text-gray-600">{{ $conversation->last_time_message->shortAbsoluteDiffForHumans() }}</span>
                    </div>
                    <span class="block ml-2 text-sm text-gray-600">{{ $conversation->lastMessage }}</span>
                </div>
            </a>
        </li>
        @empty
            <li class="text-center">not conversation</li>
        @endforelse
    </ul>
</div>

