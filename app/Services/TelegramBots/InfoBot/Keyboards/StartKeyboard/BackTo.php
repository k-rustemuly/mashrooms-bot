<?php

namespace App\Services\TelegramBots\InfoBot\Keyboards\StartKeyboard;

use App\Services\TelegramBots\InfoBot\Entities\TelegramButton;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class BackTo extends TelegramButton
{

    protected string $buttonKey = 'back-to';

    protected string $buttonText = 'НАЗАД';

    /**
     * @throws TelegramException
     */
    public function handle(CallbackQuery $query): ServerResponse
    {
        $accountInfo = $query->getMessage()->getChat();

        $keyboard = StartKeyboard::make()->getKeyboard();
        return Request::sendMessage([
            'chat_id' => $accountInfo->getId(),
            'text'          => 'Главное меню',
            // 'reply_markup'  => $keyboard
        ]);
    }
}
