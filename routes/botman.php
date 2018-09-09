<?php

use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('.*(Hi|Hello).*', BotManController::class.'@startConversation');
