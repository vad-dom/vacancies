<?php

namespace app\models;

use yii\db\ActiveRecord;

class Vacancy extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'vacancies';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'short_details'], 'required', 'message' => 'Заполните поле'],
            [['title'], 'string', 'max' => 100, 'tooLong' => 'Максимальная длина - 100 символов'],
            [['short_details'], 'string', 'max' => 200, 'tooLong' => 'Максимальная длина - 200 символов'],
            [['full_details'], 'string'],
            [['salary'], 'default', 'value' => 0],
            [
                ['salary'],
                'integer',
                'min' => 0,
                'max' => 4294967295,
                'message' => 'Введите целое число',
                'tooSmall' => 'Зарплата не должна быть меньше 0',
                'tooBig' => 'Зарплата не должна быть больше 4 294 967 295',
            ],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'short_details' => 'Краткое описание',
            'full_details' => 'Полное описание',
            'salary' => 'Зарплата',
        ];
    }

}
