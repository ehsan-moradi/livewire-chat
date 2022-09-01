<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatList extends Component
{
    public $conversations;
    public $selectedConversation;

    protected $listeners = ['chatUserSelected', 'refresh' => '$refresh'];

    public function mount()
    {
        $authId = Auth::id();

        $this->conversations = Conversation::withCount('messages')
            ->has('messages')
            ->where('sender_id', $authId)
            ->orWhere('receiver_id', $authId)
            ->has('messages')
            ->latest('last_time_message')
            ->get();
    }

    public function render()
    {
        return view('livewire.chat.chat-list');
    }

    public function chatUserSelected(Conversation $conversation)
    {
        $this->selectedConversation = $conversation;

        $this->emitTo('chat.chatbox','loadConversation', $this->selectedConversation);
    }

}
