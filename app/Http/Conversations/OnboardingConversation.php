<?php

namespace App\Http\Conversations;

use Validator;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

class OnboardingConversation extends Conversation
{
    public function askName()
    {
        $this->ask('What is your name?', function (Answer $answer) {
            $this->bot->userStorage()->save([
                'name' => $answer->getText(),
            ]);

            $this->say('Nice to meet you '.$answer->getText());
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('What is your email?', function (Answer $answer) {
            $validator = Validator::make(['email' => $answer->getText()], [
                'email' => 'email',
            ]);

            if ($validator->fails()) {
                return $this->repeat('That doesn\'t look like a valid email. Please enter a valid email.');
            }

            $this->bot->userStorage()->save([
                'email' => $answer->getText(),
            ]);

            $this->askMobile();
        });
    }

    public function askMobile()
    {
        $this->ask('Great. What is your mobile?', function (Answer $answer) {
            $this->bot->userStorage()->save([
                'mobile' => $answer->getText(),
            ]);

            $this->say('Great!');

            $this->bot->startConversation(new SelectServiceConversation());
        });
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askName();
    }
}
