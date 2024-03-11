<?php

namespace App\Exports;

use App\Models\Survey;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SurveysExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Survey::all();
    }

    public function headings(): array
    {
        return [
            '#',
            'user_id',
            'first_name',
            'last_name',
            'username',
            'chat_id',
            'Как тебя зовут ',
            'Кем и где работаешь',
            'Твой номер телефона',
            'Локация',
            'Еда',
            'Напитки',
            'Лайн-ап',
            'Активации партнеров',
            'Хотел бы создавать события с нами?',
            'В качестве кого?',
            'Отзыв',
            'created_at',
            'updated_at',
        ];
    }
}
