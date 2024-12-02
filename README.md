# WordPress Form Sender

## Установка плагина

Для установки скопируйте файлы плагина на свой сайт в папку /wp-content/plugins/form-sender.

Затем активируйте плагин стандартным способом через панель администратора.


## Настройка формы

Перейдите в раздел ```Form Sender -> Добавление формы``` и создайте вашу первую форму. 

На вкладке ```Форма``` добавьте HTML-код формы. Пример:
```
<input type="text" name="user-name"  placeholder="Ваше имя" id="name" class="name">
<input type="tel" name="user-phone"  placeholder="Ваш телефон" id="phone" class="phone">
<input type="email" name="user-mail" required placeholder="Ваш e-mail" id="mail" class="mail">
<textarea name="user-message" rows="5" placeholder="Ваш комментарий" id="message" class="message"></textarea>
<input type="submit" name="submit" value="Отправить" id="submit" class="submit">
```

На вкладке ```Письмо``` в поле ```Адреса получателей``` добавьте e-mail адрес администратора сайта или несколько адресов через запятую.

Добавьте текст письма. В текте письма можете использовать константы типа ```[имя-поля]```. Пример:
```
С сайта отправлено сообщение:

Имя: [user-name]
Телефон: [user-phone]
E-mail: [user-mail]

Комментарий:
[user-message]

Отправлено со страницы [url]
```
Добавьте тему письма. В теме также можно использовать константы.

Если вы хотите отправлять письмо-уведмление отавителю формы, на вкладке ```Письмо 2``` таким же образом заполните соответствующие поля. В этом случае в поле ```Адреса получателей``` укажите константу ```[user-mail]```

На вкладке ```Настройки``` в выпадающем списке ```Сохранять письма в архиве``` выберите значение ```Да``` чтобы все отправленные письма сохраняолись в базе. Их можно будет просматривать в разделе ```Архив писем```


## Настройка отправки и интеграции

Перейдите в раздел ```Form Sender -> Настройки отправки```.

На вкладке ```Отправка писем``` Выберите метод отправки (PHPmail или SMTP). Если вы выбрали SMTP, заполните реквизиты доступа к вашкму SMTP-серверу.
