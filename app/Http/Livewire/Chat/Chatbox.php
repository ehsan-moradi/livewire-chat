<?php

namespace App\Http\Livewire\Chat;

use Auth;
use Livewire\Component;
use App\Models\Message;
use App\Models\Conversation;
use App\Events\SendMessageEvent;

class Chatbox extends Component
{
    public $selectedConversation, $messages, $paginate = 15;

    public function getListeners()
    {
        $userId = Auth::id();
        return [
            "echo-private:chat.{$userId},SendMessageEvent" => 'broadcastMessageForReceiver',
            'loadConversation', 'addedMessage', 'loadMoreMessage'
        ];
    }

    public function loadConversation(Conversation $conversation)
    {
        $this->selectedConversation = $conversation->loadCount('messages');

        $this->messages = Message::query()
            ->where('conversation_id', $this->selectedConversation->id)
            ->skip($this->selectedConversation->messages_count - $this->paginate)
            ->take($this->paginate)
            ->get();

        $this->dispatchBrowserEvent('chatSelected');
    }

    public function addedMessage(Message $message)
    {
        $this->messages->push($message);

        $this->dispatchBrowserEvent('addRowMessage');
    }

    public function loadMoreMessage()
    {
        $this->paginate += 15;
        $this->messages = Message::query()
            ->where('conversation_id', $this->selectedConversation->id)
            ->skip($this->selectedConversation->messages_count - $this->paginate)
            ->take($this->paginate)
            ->get();
    }

    public function broadcastMessageForReceiver($event)
    {
        $this->emitTo('chat.chat-list', 'refresh');

        if ($this->selectedConversation?->id === $event['conversation_id']){
            $this->addedMessage(Message::find($event['message_id']));
        }

    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}
