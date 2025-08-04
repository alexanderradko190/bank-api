# Yii2 Bank Advanced API

## Запуск проекта

1.Клонировать проект

``````
git clone https://github.com/alexanderradko190/bank_api.git
``````

2. Перейти в папку docker

``````
cd bank-api/docker
``````

3. Собрать и запустить контейнеры

``````
docker-compose up -d --build
``````

4. Выполнить миграции базы данных

``````
docker-compose exec yii2-app php backend/yii migrate
``````

5. Сгенерировать тестовые данные через Faker

``````
docker-compose exec yii2-app php yii faker/fill
``````

6. Проект доступен

``````
http://localhost:8080
``````

Данные для проверки api-методов

1. Список банков с кратким описанием

``````
GET http://localhost:8080/bank
``````

Пример ответа:
``````
[
  {
    "id": 1,
    "name": "СберРокет",
    "country": {
      "id": 1,
      "name": "Россия"
    }
  }
]
``````

2. Получить полную информацию о банке

``````
GET http://localhost:8080/bank/1
``````

Пример ответа:

`````
{
  "id": 1,
  "name": "СберРокет",
  "description": "Крупнейший банк страны",
  "country": {
    "id": 1,
    "name": "Россия"
  },
  "cities": [
    { "id": 1, "name": "Москва" },
    { "id": 2, "name": "Воронеж" }
  ],
  "services": [
    { "id": 1, "name": "Кредит" },
    { "id": 2, "name": "Вклад" }
  ]
}
``````

3. Мягкое удаление банка

`````
DELETE http://localhost:8080/bank/1
``````

Пример ответа:

`````
{
  "message": "Банк удален"
}
``````

4. Обновление данных банка

`````
PATCH http://localhost:8080/bank/1
``````

body

`````
  {
    "name": "ГазРокет",
    "description": "Новое описание банка",
    "country_id": 1,
    "city_ids": [1],
    "service_ids": [2]
  }
``````

Пример ответа:

`````
{
  "id": 1,
  "name": "ГазРокет",
  "description": "Новое описание банка",
  "country": {
    "id": 1,
    "name": "Россия"
  },
  "cities": [
    { "id": 1, "name": "Москва" }
  ],
  "services": [
    { "id": 2, "name": "Вклад" }
  ]
}
  ``````
