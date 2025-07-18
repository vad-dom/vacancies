<h1>Сервис для хранения и подачи вакансий</h1>

<h2>Задача:</h2>
Необходимо создать сервис для хранения и подачи вакансий. Вакансия должны храниться в базе данных. Сервис должен предоставлять API, работающее поверх HTTP в формате JSON.

Детали:
Метод получения списка вакансий

Пагинация: на одной странице должно присутствовать 10 вакансий;
Cортировки: по зарплате (возрастание/убывание) и по дате создания (возрастание/убывание);
Поля в ответе: название вакансии, зарплата, описание.

Метод получения конкретной вакансии

Обязательные поля в ответе: название вакансии, зарплата, описание;
Опциональные поля (можно запросить, передав параметр fields): описание, название.

Метод создания объявления:

Принимает все вышеперечисленные поля: название, описание, описание, зарплата;
Возвращает ID созданной вакансии и код результата (ошибка или успех).

Проект должен быть реализован: backend (yii2),frontend (vue3/nuxt3), Api - REST

<h2>Для упрощения:</h2>
  <li>Не были реализованы некоторые возможности, которые напрашиваются, например, редактирование вакансии, сохранение сортировки и т.д. (но этого не было и в требованиях)</li>
  <li>Зато реализовано удаление вакансии (которого тоже не было в требованиях), но без этого сложно тестировать</li>
  <li>Отключена CSRF-защита, т.к. это тестовый проект, хотя для обработки формы это нужно - несложно доработать</li>

<h2>Требования к ПО:</h2>
<ul>
  <li>PHP >= 7.4</li>
  <li>MySQL >= 5.7</li>
  <li>Composer</li>
  <li>Node.js</li>
  <li>Git</li>
</ul>

<h2>Краткая инструкция по разворачиванию проекта:</h2>
<ul>
  <li>
    Клонировать репозиторий vacancies: 
    <ul>
      <b>git clone https://github.com/vad-dom/vacancies.git</b>
    </ul>
  </li>
  <li>
    Обновить до последних версий и установить зависимости в Composer (в папке <b>vacancies/yii</b>): 
    <ul>
      <li><b>composer update</b></li>
      <li><b>composer install</b></li>
    </ul>
  </li>
  <li>
    Установить пакеты NPM, обновить зависимости (в папке <b>vacancies/vue</b>): 
    <ul>
      <li><b>npm install</b></li>
    </ul>
  </li>
  <li>
    Настроить url, на который будут направляться запросы на сервер:
    <ul>
      <li><b>vacancies/vue/src/config.js</b></li>
    </ul>
  </li>
  <li>Создать новую базу данных</li>
  <li>
    Настроить подключение к базе данных:
    <ul>
      <li><b>vacancies/yii/config/db.php</b></li>
    </ul>
  </li>
  <li>
    Применить миграцию для создания структуры базы данных:
    <ul>
      <b>php yii migrate</b>
    </ul>
  </li>
  <li>
    При настройке веб сервера корневую папку домена указать: 
    <ul>
      <li><b>/vacancies/yii/web</b></li>
    </ul>
  </li>
</ul>
