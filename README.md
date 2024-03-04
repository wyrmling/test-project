# Тестовое задание

## Установка

- `npm i`, `composer i`, скопировать `.env.copy` в `.env`, `php artisan migrate`

## Примечания

- Решил использовать vite для Vue 2. Хотя в целом можно было бы применить mix или вообще вставить vue-код инлайново.
  Vuetify 2 только под Vue 2, тоже несколько устарел, пришлось применить несколько хаков для
  нормального отображения. В целом с библиотекой не работал, разбирался.
- Были разные варианты того, как следует разделить Vue и Laravel.
    - Laravel + SPA в одном проекте
    - Laravel + MPA в одном проекте
    - Laravel и SPA в двух разных проектах

  Сделал Vue для одной формы регистрации, т.к. этого в задании не было и интерактивность нужна была только там. Для
  полноценного проекта я бы предпочел разнести фронтенд и API на Laravel (на втором месте SPA в одном проекте с
  Laravel). Ну и Vuetify, насколько я понимаю, предполагается использовать для SPA. В противном случае необходимо все
  стили.
  Есть ещё вариант с Inertia/Livewire, не доводилось работать с ними.

- Смысл таблицы `user_countries` не совсем понял, допускаю, что в тестовом задании. Если связь 1 к 1 (предположил, что у
  одного пользователя одна страна), то лучше хранить страну в таблице `users`. Если у юзера много стран и они
  связаны/привязаны к телефонам, то лучше их хранить в таблице `phone_book`. Также возможно, что предполагалась таблица
  для хранения списка стран, как в файле `countries.json`.
- Предположил, что `phone_book` 1 ко многим, под различные номера пользователя.
- Применил хак `country-flag-emoji-polyfill` для отображения эмодзи-флагов для комбинации Windows/Chromium
- Библиотеку `awesome-phonenumber` можно было бы использовать для форматирования номера, но сделал как было в задании.
- В задании пароля в форме не было, поэтому генерируется случайный. Сейчас он никуда не отправляется, возможны варианты:
    - все же добавить поле в форму регистрации
    - сделать отправку его на почту/СМС для первого захода и заставлять пользователя генерировать новый
    - давать пользователю каждый раз вводить проверочный код через SMS/email
- В плане БД еще не хватает миграции с внешними ключами и альтернативным композитным праймари ключем для `user_id`
  и `type` из `phone_book`.
- Также необходимы фабрики и сиды для моделей.
