<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory as ResultPageFactory;

class Grid extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'YireoTraining_ExampleLokiAdminProducts::grid';
    public const PRODUCTS_RESOURCE = 'Magento_Catalog::products';

    public function __construct(
        Context $context,
        private readonly ResultPageFactory $resultPageFactory,
    ) {
        parent::__construct($context);
    }

    public function execute(): Page
    {
        $title = __('Loki Product Manager');

        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('YireoTraining_ExampleLokiAdminProducts::index');
        $resultPage->addBreadcrumb($title, $title);
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }

    protected function _isAllowed(): bool
    {
        return parent::_isAllowed() && $this->_authorization->isAllowed(self::PRODUCTS_RESOURCE);
    }
}
