<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magefan\CronSchedule\Rewrite\Magento\Cron\Observer;

use Magento\Cron\Model\Schedule;
use Magento\Framework\Profiler\Driver\Standard\StatFactory;

class ProcessCronQueueObserver extends \Magento\Cron\Observer\ProcessCronQueueObserver
{
    /**
     * @param $jobCode
     * @param $cronExpression
     * @param $time
     * @return Schedule
     * @throws \Magento\Framework\Exception\CronException
     */
    protected function createSchedule($jobCode, $cronExpression, $time)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        return $this->_scheduleFactory->create()
            ->setCronExpr($cronExpression)
            ->setJobCode($jobCode)
            ->setStatus(Schedule::STATUS_PENDING)
            ->setCreatedAt(date('Y-m-d H:i:s', $this->dateTime->gmtTimestamp()))
            ->setScheduledAt(date('Y-m-d H:i', $time))
            ->setGroup($objectManager->get(\Magefan\CronSchedule\Model\ScheduleConfig::class)->getCronJobGroup($jobCode));
    }
}