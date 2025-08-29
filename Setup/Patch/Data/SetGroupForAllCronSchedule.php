<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magefan\CronSchedule\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magefan\CronSchedule\Model\ScheduleConfig;

class SetGroupForAllCronSchedule implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var ScheduleConfig
     */
    private $scheduleConfig;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ScheduleConfig $scheduleConfig
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ScheduleConfig $scheduleConfig
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->scheduleConfig = $scheduleConfig;
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies()
    {
        return [
        ];
    }

    /**
     * @return array|string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return void
     */
    public function apply()
    {
        $connection = $this->moduleDataSetup->getConnection();
        $tableName = $this->moduleDataSetup->getTable('cron_schedule');

        $connection->startSetup();

        $select = $connection->select()
            ->from($tableName, ['job_code'])
            ->distinct()
            ->group('job_code');
        $jobCodes = $connection->fetchCol($select);

        foreach ($jobCodes as $jobCode) {
            $group = $this->scheduleConfig->getCronJobGroup($jobCode);

            if ($group) {
                $connection->update(
                    $tableName,
                    ['group' => $group],
                    ['job_code = ?' => $jobCode]
                );
            }

        }
        $connection->endSetup();
    }
}
