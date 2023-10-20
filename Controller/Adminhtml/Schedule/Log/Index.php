<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magefan\CronSchedule\Controller\Adminhtml\Schedule\Log;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Index extends Action implements HttpGetActionInterface
{
    const XML_PATH_MODULE_ENABLED = 'mfcronschedule/general/enabled';
    const XML_PATH_MODULE_CONFIGURATION = 'adminhtml/system_config/edit/section/mfcronschedule';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    private $scopeConfigInterface;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ScopeConfigInterface $scopeConfigInterface
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ScopeConfigInterface $scopeConfigInterface
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
        $this->scopeConfigInterface = $scopeConfigInterface;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|Page
     */
    public function execute()
    {
        $moduleEnabled = $this->scopeConfigInterface->getValue(self::XML_PATH_MODULE_ENABLED);

        if (!$moduleEnabled) {
            $this->messageManager->addErrorMessage(__('Magefan Cr' . 'on Schedule is dis' . 'abled. Plea' . 'se enable it fir' . 'st.'));
            $this->_redirect(self::XML_PATH_MODULE_CONFIGURATION);
            return;
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Schedule Log'));

        return $resultPage;
    }
}
