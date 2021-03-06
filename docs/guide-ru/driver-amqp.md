RabbitMQ драйвер
================

**Внимание:** Драйвер начиная с 2.0.2 этот драйвер считается устаревшим и в 2.1 будет удален.
Предлагается мигрировать на [amqp_interop](driver-amqp-interop.md).

Драйвер работает с очередью на базе RabbitMQ.

В приложении должно быть установлено расширение `php-amqplib/php-amqplib`.

Пример настройки:

```php
return [
    'bootstrap' => [
        'queue', // Компонент регистрирует свои консольные команды 
    ],
    'components' => [
        'queue' => [
            'class' => \factorenergia\queue\amqp\Queue::class,
            'host' => 'localhost',
            'port' => 5672,
            'user' => 'guest',
            'password' => 'guest',
            'queueName' => 'queue',
        ],
    ],
];
```

Консоль
-------

Для обработки очереди используются консольные команды.

```sh
yii queue/listen
```

Команда `listen` запускает обработку очереди в режиме демона. Очередь опрашивается непрерывно.
Если добавляются новые задания, то они сразу же извлекаются и выполняются. Способ наиболее эфективен
если запускать команду через [supervisor](worker.md#supervisor) или [systemd](worker.md#systemd).

Для команды `listen` доступны следующие опции:

- `--verbose`, `-v`: состояние обработки заданий выводится в консоль.
- `--isolate`: каждое задание выполняется в отдельном дочернем процессе.
- `--color`: подсветка вывода в режиме `--verbose`.
