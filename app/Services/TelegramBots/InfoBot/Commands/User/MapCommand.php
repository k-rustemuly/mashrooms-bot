<?php

namespace App\Services\TelegramBots\InfoBot\Commands\User;

use App\Services\TelegramBots\InfoBot\Keyboards\StartKeyboard\MapKeyboard;
use App\Services\TelegramBots\InfoBot\Keyboards\StartKeyboard\StartKeyboard;
use App\Services\TelegramBots\InfoBot\Traits\ImageSelector;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Throwable;

/**
 * Map command
 */
class MapCommand extends UserCommand
{
    use ImageSelector;

    /**
     * @var string
     */
    protected $name = 'map';

    /**
     * @var string
     */
    protected $description = 'Map command';

    /**
     * @var string
     */
    protected $usage = '/map';

    /**
     * @var string
     */
    protected $version = '1.2.0';

    /**
     * @return ServerResponse
     * @throws TelegramException
     * @throws Throwable
     */
    public function execute(): ServerResponse
    {

        $message = $this->getMessage();
        $chat    = $message->getChat();
        $chat_id = $chat->getId();
        // $keyboard = MapKeyboard::make()->getKeyboard();
        return  Request::sendPhoto([
            'chat_id' => $chat_id,
            'photo'    => $this->getImage('map.PNG'),
            // 'reply_markup'  => $keyboard
        ]);
    }
}
