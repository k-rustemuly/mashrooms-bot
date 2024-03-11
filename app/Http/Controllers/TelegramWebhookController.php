<?php

namespace App\Http\Controllers;

use App\Services\TelegramBots\InfoBot\InfoBot;
use Longman\TelegramBot\Exception\TelegramException;
use Throwable;

class TelegramWebhookController extends Controller
{
    /**
     * @throws Throwable
     */
    public function webhook()
    {
        try {
            $bot = InfoBot::makeBot();
            $bot->enableMysql();
            $bot->handle();
        } catch (TelegramException $e) {
            report_app($e);
        }
    }

    public function setWebhook()
    {
        $bot = InfoBot::makeBot();
        $response = $bot->setWebHook(route('webhook.telegram'));
        dd($response);
    }
}
