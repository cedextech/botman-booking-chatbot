<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class BookingConversation extends Conversation
{
    public function confirmBooking()
    {
        $user = $this->bot->userStorage()->find();

        $message = '------------------------------------------------ <br>';
        $message .= 'Name : '.$user->get('name').'<br>';
        $message .= 'Email : '.$user->get('email').'<br>';
        $message .= 'Mobile : '.$user->get('mobile').'<br>';
        $message .= 'Service : '.$user->get('service').'<br>';
        $message .= 'Date : '.$user->get('date').'<br>';
        $message .= 'Time : '.$user->get('timeSlot').'<br>';
        $message .= '------------------------------------------------';

        $this->say('Great. Your booking has been confirmed. Here is your booking details. <br><br>'.$message);
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->confirmBooking();
    }
}
