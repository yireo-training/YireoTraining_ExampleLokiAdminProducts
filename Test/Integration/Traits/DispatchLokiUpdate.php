<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Test\Integration\Traits;

use Laminas\Http\Header\GenericHeader;
use Laminas\Http\Headers;
use Loki\Components\Util\Security\AjaxSignature;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Acl\Builder as AclBuilder;
use Magento\Framework\App\Request\Http as HttpRequest;

trait DispatchLokiUpdate
{
    private function dispatchLokiUpdate(string $handle, string $blockName, array $update, array $params = []): void
    {
        $payload = [
            'targets' => [],
            'handles' => [$handle],
            'pageHandles' => [],
            'updates' => [['blockName' => $blockName, 'update' => $update]],
            'request' => ['params' => $params],
        ];

        $payload['signature'] = $this->_objectManager->get(AjaxSignature::class)->sign([
            'handles' => $payload['handles'],
            'pageHandles' => $payload['pageHandles'],
            'request' => $payload['request'],
        ]);

        $headers = new Headers();
        $headers->addHeader(GenericHeader::fromString('X-Alpine-Request: 1'));

        /** @var HttpRequest $request */
        $request = $this->getRequest();
        $request->setHeaders($headers);
        $request->setMethod(HttpRequest::METHOD_POST);
        $request->setContent((string)json_encode($payload));

        $this->dispatch('backend/loki_components/index/html');
    }

    private function denyProductsAcl(): void
    {
        $this->_objectManager->get(AclBuilder::class)->getAcl()->deny(
            $this->_auth->getUser()->getRoles(),
            'Magento_Catalog::products'
        );
    }

    private function reloadProduct(int $productId): ProductInterface
    {
        return $this->_objectManager->get(ProductRepositoryInterface::class)->getById($productId, false, null, true);
    }
}
