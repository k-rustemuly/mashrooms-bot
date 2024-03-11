<?php

namespace App\Services\TelegramBots\InfoBot\Keyboards\StartKeyboard;

use App\Services\TelegramBots\InfoBot\Keyboards\TelegramKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Longman\TelegramBot\Entities\Keyboard;

class StartKeyboard extends TelegramKeyboard
{
    public function buildKeyboard(string $value = ''): Keyboard
    {
        return new InlineKeyboard(
            [$this->inlineButton(new FestivalMap())],
            [$this->inlineButton(new Feedback())],
            // [(new InlineKeyboardButton('NEW ОБРАТНАЯ СВЯЗЬ 💝 + ПОДАРОК 🎁'))->setCallbackData('/survey')],
            [(new InlineKeyboardButton('ГОРЯЧАЯ ЛИНИЯ 🆘'))->setUrl('https://t.me/alinaVromanova')],
        );
    }
}
