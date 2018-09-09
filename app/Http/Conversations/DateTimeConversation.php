<?php

namespace App\Http\Conversations;

use Carbon\Carbon;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class DateTimeConversation extends Conversation
{
    public function askDate()
    {
        $availableDates = [
            Carbon::today()->addDays(1),
            Carbon::today()->addDays(2),
            Carbon::today()->addDays(3),
        ];

        $question = Question::create('Select the date')
            ->callbackId('select_date')
            ->addButtons([
                Button::create($availableDates[0]->format('M d'))->value($availableDates[0]->format('Y-m-d')),
                Button::create($availableDates[1]->format('M d'))->value($availableDates[1]->format('Y-m-d')),
                Button::create($availableDates[2]->format('M d'))->value($availableDates[2]->format('Y-m-d')),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->bot->userStorage()->save([
                    'date' => $answer->getValue(),
                ]);

                $this->askTime();
            }
        });
    }

    public function askTime()
    {
        $question = Question::create('Select a time slot')
            ->callbackId('select_time')
            ->addButtons([
                Button::create('9 AM')->value('9 AM'),
                Button::create('1 PM')->value('1 PM'),
                Button::create('3 PM')->value('3 PM'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->bot->userStorage()->save([
                    'timeSlot' => $answer->getValue(),
                ]);

                $this->bot->startConversation(new BookingConversation());
            }
        });
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askDate();
    }
}
