<?php

namespace App\Services\TelegramBots\InfoBot\Commands\User;

use App\Exports\SurveysExport;
use App\Services\TelegramBots\InfoBot\Keyboards\StartKeyboard\StartKeyboard;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

/**
 * Start command
 */
class ExportCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'export';

    /**
     * @var string
     */
    protected $description = 'Export command';

    /**
     * @var string
     */
    protected $usage = '/export';

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
        $user    = $message->getFrom();
        $chat    = $message->getChat();
        $text    = trim($message->getText(true));
        $chat_id = $chat->getId();

        if(!in_array($user->getUsername(), config('telegram.admins'), true))
        {
            return Request::sendMessage([
                'chat_id'       => $chat_id,
                'text'          => 'У вас нет прав!',
            ]);
        }
        Excel::store(new SurveysExport(), 'survey.xlsx');
        $filePath = storage_path('app/survey.xlsx');
        return Request::sendDocument([
            'chat_id'       => $chat_id,
            'document' => $filePath,
        ]);
    }
}
