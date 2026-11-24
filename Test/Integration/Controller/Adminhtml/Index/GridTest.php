<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Test\Integration\Controller\Adminhtml\Index;

use Magento\Framework\Acl\Builder as AclBuilder;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\TestFramework\Fixture\AppArea;
use Magento\TestFramework\TestCase\AbstractBackendController;

#[AppArea('adminhtml')]
class GridTest extends AbstractBackendController
{
    protected $resource = 'YireoTraining_ExampleLokiAdminProducts::grid';
    protected $uri = 'backend/loki_admin_products/index/grid';

    public function testRendersGridForAdmin(): void
    {
        $this->dispatch($this->uri);

        $this->assertSame(200, $this->getResponse()->getHttpResponseCode());
    }

    public function testDeniesGridWithoutProductsAcl(): void
    {
        $this->_objectManager->get(AclBuilder::class)->getAcl()->deny(
            $this->_auth->getUser()->getRoles(),
            'Magento_Catalog::products'
        );
        $this->dispatch($this->uri);

        $this->assertSame(403, $this->getResponse()->getHttpResponseCode());
    }

    public function testRefusesPostRequest(): void
    {
        /** @var HttpRequest $request */
        $request = $this->getRequest();
        $request->setMethod(HttpRequest::METHOD_POST);
        $this->dispatch($this->uri);

        $this->assertNotSame(200, $this->getResponse()->getHttpResponseCode());
    }
}
