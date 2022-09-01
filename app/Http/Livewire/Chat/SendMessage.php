<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class SendMessage extends Component
{
    public $body, $conversation;

    public function sendMessage()
    {
        if (is_null($this->body)) return null;

        $message = Message::query()->create([
            'conversation_id' => $this->conversation->id,
           'sender_id' => Auth::id(),
           'receiver_id' => $this->conversation->user_instance->id,
           'body' => $this->body,
        ]);

        $this->conversation->last_time_message = $message->created_at;
        $this->conversation->save();

        $this->reset('body');

        $this->emitTo('chat.chatbox','addedMessage', $message->id);
        $this->emitTo('chat.chat-list','refresh');
    }

    public function render()
    {
        return view('livewire.chat.send-message');
    }
}
