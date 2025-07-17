<?php

use yii\db\Migration;

class m250712_162833_vacancies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vacancies', [
            'id' => $this->primaryKey()->comment('ID'),
            'title' => $this->string(100)->notNull()->comment('Название'),
            'short_details' => $this->string(200)->notNull()->comment('Краткое описание'),
            'full_details' => $this->text()->null()->comment('Полное описание'),
            'salary' => $this->integer()->notNull()->comment('Зарплата'),
            'created_at' => $this
                ->timestamp()
                ->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP')
                ->comment('Дата и время создания'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vacancies');
    }
}
