<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Test\Integration\Controller\Adminhtml\Index;

use Magento\Framework\Acl\Builder as AclBuilder;
use Magento\TestFramework\Fixture\AppArea;
use Magento\TestFramework\TestCase\AbstractBackendController;

#[AppArea('adminhtml')]
class FormTest extends AbstractBackendController
{
    protected $resource = 'YireoTraining_ExampleLokiAdminProducts::form';
    protected $uri = 'backend/loki_admin_products/index/form';

    public function testDeniesFormWithoutProductsAcl(): void
    {
        $this->_objectManager->get(AclBuilder::class)->getAcl()->deny(
            $this->_auth->getUser()->getRoles(),
            'Magento_Catalog::products'
        );
        $this->dispatch($this->uri);

        $this->assertSame(403, $this->getResponse()->getHttpResponseCode());
    }
}
