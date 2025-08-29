<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magefan\CronSchedule\Model;

use Magento\Cron\Model\Config as CronConfig;

class ScheduleConfig
{
    /**
     * @var CronConfig
     */
    private $cronConfig;

    /**
     * @param CronConfig $cronConfig
     */
    public function __construct(
        CronConfig $cronConfig
    ) {
        $this->cronConfig = $cronConfig;
    }

    /**
     * @param $jobCode
     * @return int|string|null
     */
    public function getCronJobGroup($jobCode)
    {
        $cronJobs = $this->cronConfig->getJobs();

        foreach ($cronJobs as $group => $groupConfig) {

            if (array_key_exists($jobCode, $groupConfig)) {
                return $group;
            }
        }
        return null;
    }
}
