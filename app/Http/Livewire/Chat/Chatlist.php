<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;

class Chatlist extends Component
{

    public $auth_id;
    public $conversations;
    public $receiverInstance;

    public $name;

    public function getChatUserInstance(Conversation $conversation, $request){
        $this->auth_id = auth()->id();

        if ($conversation->sender_id == $this->auth_id) {
            $this->receiverInstance = User::firstWhere('id', $conversation->receiver_id);
        } else {
            $this->receiverInstance = User::firstWhere('id', $conversation->sender_id);
        }

        if (isset($request)) {
            return $this->receiverInstance->$request;
        }

    }
    public function mount(){
        $this->auth_id = auth()->id();
        $this->conversations = Conversation::where('sender_id', $this->auth_id)
        ->orWhere('receiver_id',$this->auth_id)->orderBy('last_time_message','DESC')->get();
    }
    public function render() 
    {
        return view('livewire.chat.chatlist');
    }
}
