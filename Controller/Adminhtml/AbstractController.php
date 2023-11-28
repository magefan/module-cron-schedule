<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magefan\CronSchedule\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;

abstract class AbstractController extends Action
{
    const XML_PATH_MODULE_ENABLED = 'mfcronschedule/general/enabled';
    const XML_PATH_MODULE_CONFIGURATION = 'adminhtml/system_config/edit/section/mfcronschedule';

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfigInterface
     */
    public function __construct(Context $context, ScopeConfigInterface $scopeConfigInterface)
    {
        $this->scopeConfigInterface = $scopeConfigInterface;
        parent::__construct($context);
    }

    /**
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function dispatch(RequestInterface $request)
    {
        $moduleEnabled = $this->scopeConfigInterface->getValue(self::XML_PATH_MODULE_ENABLED);

        if (!$moduleEnabled) {
            $this->messageManager->addErrorMessage(
                __($this->message ?:
                    'Mage' . 'fan Cr' . 'on Schedule is dis' . 'abled. Plea' . 'se enable it fir' . 'st.')
            );
            $this->_redirect(self::XML_PATH_MODULE_CONFIGURATION);
            return;
        }

        return parent::dispatch($request);
    }
}
