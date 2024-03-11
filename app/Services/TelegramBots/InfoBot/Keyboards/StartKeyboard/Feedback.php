<?php

namespace App\Services\TelegramBots\InfoBot\Keyboards\StartKeyboard;

use App\Services\TelegramBots\InfoBot\Entities\TelegramButton;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class Feedback extends TelegramButton
{
    protected string $buttonKey = 'feedback';

    protected string $buttonText = 'ОБРАТНАЯ СВЯЗЬ 💝 + ПОДАРОК 🎁';

    /**
     * @throws TelegramException
     */
    public function handle(CallbackQuery $query): ServerResponse
    {
        $accountInfo = $query->getMessage()->getChat();

        return Request::sendMessage([
            'chat_id' => $accountInfo->getId(),
            'text'          => 'Нажми сюда /survey',
        ]);

    }
}
