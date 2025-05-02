<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Provider;

use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\DataObject;
use Yireo\LokiAdminComponents\RepositoryProvider\RepositoryProviderInterface;

class ProductRepositoryProvider implements RepositoryProviderInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductInterfaceFactory $productFactory,
    ) {
    }

    public function getRepository()
    {
        return $this->productRepository;
    }

    public function create(): DataObject
    {
        return $this->productFactory->create();
    }
}
