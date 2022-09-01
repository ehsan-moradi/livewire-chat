<?php

namespace App\Http\Livewire\Chat;

use App\Models\User;
use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class SearchBox extends Component
{
    public $search;
    public $result;
    public $selectedConversation;

    protected $listeners = ['chatUserSelected'];

    public function render()
    {
        return view('livewire.chat.search-box');
    }

    public function updatedSearch()
    {
        $this->result = User::query()
            ->where('id','!=', Auth::id())
            ->where('name','like','%'. $this->search. '%')
            ->OrWhere('email', 'like','%'. $this->search. '%')
            ->where('id','!=', Auth::id())
            ->get();
    }

    public function checkConversation($receiverId)
    {
        $authId = Auth::id();

        $conversation = Conversation::query()
            ->where('receiver_id',$authId)
            ->where('sender_id',$receiverId)
            ->orWhere('receiver_id', $receiverId)
            ->where('sender_id',$authId)
            ->first();

        if (!$conversation){
            $conversation = Conversation::query()->create([
                'receiver_id' => $receiverId,
                'sender_id' => $authId,
                'last_time_message' => now()
            ]);
        }

        $this->emitTo('chat.chatbox','loadConversation', $conversation);
    }
}
