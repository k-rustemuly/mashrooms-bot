<?php

namespace App\Services\TelegramBots\InfoBot\Keyboards\StartKeyboard;


use App\Services\TelegramBots\InfoBot\Entities\TelegramButton;
use App\Services\TelegramBots\InfoBot\Traits\ImageSelector;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class FestivalMap extends TelegramButton
{
    use ImageSelector;

    protected string $buttonKey = 'fectival-map';

    protected string $buttonText = 'КАРТА НАШЕГО ФЕСТИВАЛЯ 📌';

    /**
     * @throws TelegramException
     */
    public function handle(CallbackQuery $query): ServerResponse
    {
        $accountInfo = $query->getMessage()->getChat();

        $image = $this->getImage('map.PNG');

        return Request::sendPhoto([
            'chat_id' => $accountInfo->getId(),
            'photo'    => $image
        ]);

        // // $keyboard = StartKeyboard::make()->getKeyboard();
        // $keyboard = MapKeyboard::make()->getKeyboard();
        // return Request::sendMessage([
        //     'chat_id' => $accountInfo->getId(),
        //     'text'          => 'Че то там',
        //     'reply_markup'  => $keyboard
        // ]);
    }
}
