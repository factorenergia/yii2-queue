<?php
$config = [
    'id' => 'yii2-queue-app',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'runtimePath' => dirname(dirname(__DIR__)) . '/runtime',
    'bootstrap' => [
        'fileQueue',
        'mysqlQueue',
        'sqliteQueue',
        'pgsqlQueue',
        'redisQueue',
        'amqpQueue',
        'amqpInteropQueue',
        'beanstalkQueue',
    ],
    'components' => [
        'syncQueue' => [
            'class' => \factorenergia\queue\sync\Queue::class,
        ],
        'fileQueue' => [
            'class' => \factorenergia\queue\file\Queue::class,
        ],
        'mysql' => [
            'class' => \yii\db\Connection::class,
            'dsn' => sprintf(
                'mysql:host=%s;dbname=%s',
                getenv('MYSQL_HOST') ?: 'localhost',
                getenv('MYSQL_DATABASE') ?: 'yii2_queue_test'
            ),
            'username' => getenv('MYSQL_USER') ?: 'root',
            'password' => getenv('MYSQL_PASSWORD') ?: '',
            'charset' => 'utf8',
            'attributes' => [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode = "STRICT_ALL_TABLES"',
            ],
        ],
        'mysqlQueue' => [
            'class' => \factorenergia\queue\db\Queue::class,
            'db' => 'mysql',
            'mutex' => [
                'class' => \yii\mutex\MysqlMutex::class,
                'db' => 'mysql',
            ],
        ],
        'sqlite' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'sqlite:@runtime/yii2_queue_test.db',
        ],
        'sqliteQueue' => [
            'class' => \factorenergia\queue\db\Queue::class,
            'db' => 'sqlite',
            'mutex' => \yii\mutex\FileMutex::class,
        ],
        'pgsql' => [
            'class' => \yii\db\Connection::class,
            'dsn' => sprintf(
                'pgsql:host=%s;dbname=%s',
                getenv('POSTGRES_HOST') ?: 'localhost',
                getenv('POSTGRES_DB') ?: 'yii2_queue_test'
            ),
            'username' => getenv('POSTGRES_USER') ?: 'postgres',
            'password' => getenv('POSTGRES_PASSWORD') ?: '',
            'charset' => 'utf8',
        ],
        'pgsqlQueue' => [
            'class' => \factorenergia\queue\db\Queue::class,
            'db' => 'pgsql',
            'mutex' => [
                'class' => \yii\mutex\PgsqlMutex::class,
                'db' => 'pgsql',
            ],
            'mutexTimeout' => 0,
        ],
        'redis' => [
            'class' => \yii\redis\Connection::class,
            'hostname' => getenv('REDIS_HOST') ?: 'localhost',
            'database' => getenv('REDIS_DB') ?: 1,
        ],
        'redisQueue' => [
            'class' => \factorenergia\queue\redis\Queue::class,
        ],
        'amqpQueue' => [
            'class' => \factorenergia\queue\amqp\Queue::class,
            'host' => getenv('RABBITMQ_HOST') ?: 'localhost',
            'user' => getenv('RABBITMQ_USER') ?: 'guest',
            'password' => getenv('RABBITMQ_PASSWORD') ?: 'guest',
            'queueName' => 'queue-basic',
            'exchangeName' => 'exchange-basic',
        ],
        'amqpInteropQueue' => [
            'class' => \factorenergia\queue\amqp_interop\Queue::class,
            'host' => getenv('RABBITMQ_HOST') ?: 'localhost',
            'user' => getenv('RABBITMQ_USER') ?: 'guest',
            'password' => getenv('RABBITMQ_PASSWORD') ?: 'guest',
            'queueName' => 'queue-interop',
            'exchangeName' => 'exchange-interop',
        ],
        'beanstalkQueue' => [
            'class' => \factorenergia\queue\beanstalk\Queue::class,
            'host' => getenv('BEANSTALK_HOST') ?: 'localhost',
        ],
    ],
];

if (defined('GEARMAN_SUCCESS')) {
    $config['bootstrap'][] = 'gearmanQueue';
    $config['components']['gearmanQueue'] = [
        'class' => \factorenergia\queue\gearman\Queue::class,
        'host' => getenv('GEARMAN_HOST') ?: 'localhost',
    ];
}

if (getenv('AWS_SQS_ENABLED')) {
    $config['bootstrap'][] = 'sqsQueue';
    $config['components']['sqsQueue'] = [
        'class' => \factorenergia\queue\sqs\Queue::class,
        'url' => getenv('AWS_SQS_URL'),
        'key' => getenv('AWS_KEY'),
        'secret' => getenv('AWS_SECRET'),
        'region' => getenv('AWS_REGION'),
    ];
}

return $config;
