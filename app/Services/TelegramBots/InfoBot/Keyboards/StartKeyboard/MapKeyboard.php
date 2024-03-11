<?php

namespace App\Services\TelegramBots\InfoBot\Keyboards\StartKeyboard;

use App\Services\TelegramBots\InfoBot\Keyboards\TelegramKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\Keyboard;

class MapKeyboard extends TelegramKeyboard
{
    public function buildKeyboard(string $value = ''): Keyboard
    {
        return new InlineKeyboard(
            [$this->inlineButton(new BackTo())],
        );
    }
}
