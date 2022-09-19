<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Message;
use App\Events\SendMessageEvent;
use Illuminate\Support\Facades\Auth;

class SendMessage extends Component
{
    public $body, $conversation, $message;

    protected $listeners = ['dispatchSendMessage'];

    public function sendMessage()
    {
        if (is_null($this->body)) return null;

        $this->message = Message::query()->create([
            'conversation_id' => $this->conversation->id,
            'sender_id'       => Auth::id(),
            'receiver_id'     => $this->conversation->user_instance->id,
            'body'            => $this->body,
        ]);

        $this->conversation->last_time_message = $this->message->created_at;
        $this->conversation->save();

        $this->reset('body');

        $this->emitTo('chat.chatbox', 'addedMessage', $this->message->id);
        $this->emitTo('chat.chat-list', 'refresh');
        $this->emitSelf('dispatchSendMessage');
    }

    public function dispatchSendMessage()
    {
        broadcast(new SendMessageEvent(
                Auth::user(),
                $this->message,
                $this->conversation,
                $this->conversation->user_instance)
        );
    }

    public function render()
    {
        return view('livewire.chat.send-message');
    }
}
