<?php

namespace app\modules\calendar\models;

use Yii;

/**
 * This is the model class for table "calendarEvent".
 *
 * @property integer $id
 * @property integer $year
 * @property integer $month
 * @property integer $day
 * @property string $time
 * @property string $event
 */
class CalendarEvent extends \yii\db\ActiveRecord
{
    public static $_month_array = [
        '1' => 'Январь',
        '2' => 'Февраль',
        '3' => 'Март',
        '4' => 'Апрель',
        '5' => 'Май',
        '6' => 'Июнь',
        '7' => 'Июль',
        '8' => 'Август',
        '9' => 'Сентябрь',
        '10' => 'Октябрь',
        '11' => 'Ноябрь',
        '12' => 'Декабрь'
    ];

    public $month_array_name = [
        '1' => 'января',
        '2' => 'февраля',
        '3' => 'марта',
        '4' => 'апреля',
        '5' => 'мая',
        '6' => 'июня',
        '7' => 'июля',
        '8' => 'августа',
        '9' => 'сентября',
        '10' => 'октября',
        '11' => 'ноября',
        '12' => 'декабря'
    ];

    public $week_array = [
        '0' => 'Пн.',
        '1' => 'Вт.',
        '2' => 'Ср.',
        '3' => 'Чт.',
        '4' => 'Пт.',
        '5' => 'Сб.',
        '6' => 'Вс.',
    ];

    public $time_array = [
        '1' => '9:00',
        '2' => '10:00',
        '3' => '11:00',
        '4' => '12:00',
        '5' => '13:00',
        '6' => '14:00',
        '7' => '15:00',
        '8' => '16:00',
        '9' => '17:00',
        '10' => '18:00',
    ];

    public static $_year_array = [
        '2017' => '2017',
        '2018' => '2018',
        '2019' => '2019',
        '2020' => '2020',
        '2021' => '2021',
        '2022' => '2022',
        '2023' => '2023',
        '2024' => '2024',
        '2025' => '2025',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendarEvent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'month', 'day', 'time', 'event'], 'required'],
            [['year', 'month', 'day', 'time'], 'integer'],
            [['event'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'year' => 'Год',
            'month' => 'Месяц',
            'day' => 'Число',
            'time' => 'Время',
            'event' => 'Событие',
        ];
    }
}
