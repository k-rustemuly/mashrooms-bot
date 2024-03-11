<?php

namespace App\Services\TelegramBots\InfoBot\Commands\User;

use App\Models\Survey;
use App\Services\TelegramBots\InfoBot\Keyboards\StartKeyboard\StartKeyboard;
use App\Services\TelegramBots\InfoBot\Traits\ImageSelector;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\KeyboardButton;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class SurveyCommand extends UserCommand
{
    use ImageSelector;

    /**
     * @var string
     */
    protected $name = 'survey';

    /**
     * @var string
     */
    protected $description = 'Опрос';

    /**
     * @var string
     */
    protected $usage = '/survey';

    /**
     * @var string
     */
    protected $version = '0.4.0';

    /**
     * @var bool
     */
    protected $need_mysql = true;

    /**
     * @var bool
     */
    protected $private_only = true;

    /**
     * Conversation Object
     *
     * @var Conversation
     */
    protected $conversation;

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        $message = $this->getMessage();
        $chat    = $message->getChat();
        $user    = $message->getFrom();
        $text    = trim($message->getText(true));
        $chat_id = $chat->getId();
        $user_id = $user->getId();

        $data = [
            'chat_id'      => $chat_id,
            'reply_markup' => Keyboard::remove(['selective' => true]),
        ];

        $this->conversation = new Conversation($user_id, $chat_id, $this->getName());

        $notes = &$this->conversation->notes;
        !is_array($notes) && $notes = [];

        $state = $notes['state'] ?? 0;

        $result = Request::emptyResponse();

        $is_have = false;
        switch ($state) {
            case 0:
                if ($text === '') {
                    Request::sendPhoto([
                        'chat_id' => $chat_id,
                        'photo'    => $this->getImage('2-1.png')
                    ]);
                    $notes['state'] = 0;
                    $this->conversation->update();
                    $data['text'] = 'Как тебя зовут 👑';
                    $result = Request::sendMessage($data);
                    break;
                }

                $notes['name'] = $text;
                $text          = '';

            case 1:
                if ($text === '') {
                    $notes['state'] = 1;
                    $this->conversation->update();
                    $data['text'] = 'Кем и где работаешь 🦾';
                    $result = Request::sendMessage($data);
                    break;
                }

                $notes['work'] = $text;
                $text             = '';

            case 2:
                if ($message->getContact() === null) {
                    $notes['state'] = 2;
                    $this->conversation->update();

                    $data['reply_markup'] = (new Keyboard(
                        (new KeyboardButton('Поделиться контактом'))->setRequestContact(true)
                    ))
                        ->setOneTimeKeyboard(true)
                        ->setResizeKeyboard(true)
                        ->setSelective(true);

                    $data['text'] = 'Твой номер телефона ☎';
                    if ($text !== '') {
                        $data['text'] = 'Нажми на кнопку "Поделиться контактом"';
                    }
                    $result = Request::sendMessage($data);
                    break;
                }

                $notes['phone_number'] = $message->getContact()->getPhoneNumber();

            case 3:
                if ($text === '' || !in_array($text, ['😍', '😕'], true)) {
                    Request::sendPhoto([
                        'chat_id' => $chat_id,
                        'photo'    => $this->getImage('3-1.png')
                    ]);
                    $notes['state'] = 3;
                    $this->conversation->update();

                    $data['reply_markup'] = (new Keyboard(['😍', '😕']))
                        ->setResizeKeyboard(true)
                        ->setOneTimeKeyboard(true)
                        ->setSelective(true);

                    $data['text'] = 'Локация 📍';
                    if ($text !== '') {
                        $data['text'] = 'Выберите один из вариантов';
                    }

                    $result = Request::sendMessage($data);
                    break;
                }

                $notes['location'] = $text === '😍' ? '+':'-';
                $text          = '';

            case 4:
                if ($text === '' || !in_array($text, ['🤤', '🤢'], true)) {
                    $notes['state'] = 4;
                    $this->conversation->update();

                    $data['reply_markup'] = (new Keyboard(['🤤', '🤢']))
                        ->setResizeKeyboard(true)
                        ->setOneTimeKeyboard(true)
                        ->setSelective(true);

                    $data['text'] = 'Еда 🌭';
                    if ($text !== '') {
                        $data['text'] = 'Выберите один из вариантов';
                    }

                    $result = Request::sendMessage($data);
                    break;
                }

                $notes['food'] = $text === '🤤' ? '+':'-';
                $text          = '';

            case 5:
                if ($text === '' || !in_array($text, ['🤩', '😞'], true)) {
                    $notes['state'] = 5;
                    $this->conversation->update();

                    $data['reply_markup'] = (new Keyboard(['🤩', '😞']))
                        ->setResizeKeyboard(true)
                        ->setOneTimeKeyboard(true)
                        ->setSelective(true);

                    $data['text'] = 'Напитки 🍹';
                    if ($text !== '') {
                        $data['text'] = 'Выберите один из вариантов';
                    }

                    $result = Request::sendMessage($data);
                    break;
                }

                $notes['drink'] = $text === '🤩' ? '+':'-';
                $text          = '';

            case 6:
                if ($text === '' || !in_array($text, ['🔥', '🥵'], true)) {
                    $notes['state'] = 6;
                    $this->conversation->update();

                    $data['reply_markup'] = (new Keyboard(['🔥', '🥵']))
                        ->setResizeKeyboard(true)
                        ->setOneTimeKeyboard(true)
                        ->setSelective(true);

                    $data['text'] = 'Лайн-ап 🎙';
                    if ($text !== '') {
                        $data['text'] = 'Выберите один из вариантов';
                    }

                    $result = Request::sendMessage($data);
                    break;
                }

                $notes['line_up'] = $text === '🔥' ? '+':'-';
                $text          = '';

            case 7:
                if ($text === '' || !in_array($text, ['💖', '😑'], true)) {
                    $notes['state'] = 7;
                    $this->conversation->update();

                    $data['reply_markup'] = (new Keyboard(['💖', '😑']))
                        ->setResizeKeyboard(true)
                        ->setOneTimeKeyboard(true)
                        ->setSelective(true);

                    $data['text'] = 'Активации партнеров 🎡';
                    if ($text !== '') {
                        $data['text'] = 'Выберите один из вариантов';
                    }

                    $result = Request::sendMessage($data);
                    break;
                }

                $notes['partner_activations'] = $text === '💖' ? '+':'-';
                $text          = '';

            case 8:
                if ($text === '' || !in_array($text, ['✔Да', '✖Нет'], true)) {
                    $notes['state'] = 8;
                    $this->conversation->update();

                    $data['reply_markup'] = (new Keyboard(['✔Да', '✖Нет']))
                        ->setResizeKeyboard(true)
                        ->setOneTimeKeyboard(true)
                        ->setSelective(true);

                    // $data['text'] = '🎊 Хотел бы создавать события с нами?';
                    if ($text !== '') {
                        $data['text'] = 'Выберите один из вариантов';
                        $result = Request::sendMessage($data);
                    }else
                    {
                        $data['photo'] = $this->getImage('4-1.png');
                        $result = Request::sendPhoto($data);
                    }

                    break;
                }

                $notes['create_events'] = $text === '✔Да' ? '+':'-';
                if($text === '✖Нет')
                {
                    $notes['state'] = 10;
                    $this->conversation->update();
                }
                else{
                    $is_have = true;
                    $text          = '';
                }
            case 9:
                if ($is_have && ($text === '' || !in_array($text, ['🎩 Партнера', '🤓 Волонтера', '🙆 Хочу к вам в агентство'], true))) {
                    $notes['state'] = 9;
                    $this->conversation->update();

                    $data['reply_markup'] = (new Keyboard(['🎩 Партнера', '🤓 Волонтера', '🙆 Хочу к вам в агентство']))
                        ->setResizeKeyboard(true)
                        ->setOneTimeKeyboard(true)
                        ->setSelective(true);

                    $data['text'] = '👀 В качестве кого?';
                    if ($text !== '') {
                        $data['text'] = 'Выберите один из вариантов';
                    }

                    $result = Request::sendMessage($data);
                    break;
                }
                $notes['role'] = '-';
                if($text === '🤓 Волонтера') $notes['role'] = 'Волонтер';
                else if($text === '🙆 Хочу к вам в агентство') $notes['role'] = 'Хочу к вам в агентство';
                else if($text === '🎩 Партнера') $notes['role'] = 'Партнер';
                $text          = '';

            case 10:
                if ($text === '') {
                    $notes['state'] = 10;
                    $this->conversation->update();
                    $data['text'] = 'Остались вопросы/предложения? 💬 Велкам 🤗';
                    $result = Request::sendMessage($data);
                    break;
                }

                $notes['comment'] = $text;
                $text          = '';
            case 11:
                $this->conversation->update();
                // $out_text = '/Результат опроса:' . PHP_EOL;
                unset($notes['state']);
                $survey = [
                    'user_id' => $user_id,
                    'chat_id' => $chat_id,
                    'first_name' => $user->getFirstName(),
                    'last_name' => $user->getLastName(),
                    'username' => $user->getUsername()
                ];
                foreach ($notes as $k => $v) {
                    $survey[$k] = $v;
                    // $out_text .= PHP_EOL . ucfirst($k) . ': ' . $v;
                }
                Survey::create($survey);
                // $data['text'] = $out_text;
                $this->conversation->stop();
                Request::sendPhoto([
                    'chat_id' => $chat_id,
                    'photo'    => $this->getImage('5-1.png')
                ]);
                Request::sendMessage([
                    'chat_id'      => $chat_id,
                    'reply_markup' => Keyboard::remove(['selective' => true]),
                    'text' => 'Лови стикерпак 😺'. PHP_EOL . 'https://t.me/addstickers/mshrms_agency'
                ]);
                $result = Request::sendMessage([
                    'chat_id'      => $chat_id,
                    'reply_markup' => Keyboard::remove(['selective' => true]),
                    'text' => 'Покажи это сообщение у зоны MUSHROOMS (прямо напротив сцены) и забирай свой подарок крутого гостя! 🎁'
                ]);
                break;
        }

        return $result;
    }
}
