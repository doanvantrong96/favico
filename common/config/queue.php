<?php
return [
    'class' => '\yii\queue\db\Queue',
    'db' => 'db', // DB connection component or its config ss
    'tableName' => '{{%queue}}', // Table name
    'channel' => 'default', // Queue channel key
    'mutex' => '\yii\mutex\MysqlMutex', // Mutex used to sync queries
    'ttr' => 10 * 60, // Max time for job execution
    'attempts' => 3, // Max number of attempts
];