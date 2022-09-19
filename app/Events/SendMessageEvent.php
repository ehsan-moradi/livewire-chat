<?php

namespace App\Events;

use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private User         $receiver;
    private User         $user;
    private Message      $message;
    private Conversation $conversation;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param Message $message
     * @param Conversation $conversation
     * @param User $receiver
     *
     */
    public function __construct(User $user, Message $message, Conversation $conversation, User $receiver)
    {
        $this->user         = $user;
        $this->message      = $message;
        $this->receiver     = $receiver;
        $this->conversation = $conversation;

    }

    public function broadcastWith()
    {
        return [
            'user_id'      => $this->user->id,
            'receiver_id'  => $this->receiver->id,
            'message_id'      => $this->message->id,
            'conversation_id' => $this->conversation->id,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        info($this->receiver->id);
        return new PrivateChannel('chat.' . $this->receiver->id);
    }
}
