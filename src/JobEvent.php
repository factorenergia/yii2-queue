<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace factorenergia\queue;

use yii\base\Event;

/**
 * Job Event.
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */
abstract class JobEvent extends Event
{
    /**
     * @var Queue
     * @inheritdoc
     */
    public $sender;
    /**
     * @var string|null unique id of a job
     */
    public $id;
    /**
     * @var JobInterface|null
     */
    public $job;
    /**
     * @var int time to reserve in seconds of the job
     */
    public $ttr;
}
