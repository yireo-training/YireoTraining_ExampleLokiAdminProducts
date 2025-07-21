<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Component\Grid;

use Magento\Eav\Model\Config as EavConfig;
use Loki\Components\Component\ComponentContextInterface;
use Magento\Catalog\Model\ProductTypes\ConfigInterface as ProductTypesConfig;

class GridContext implements ComponentContextInterface
{
    public function __construct(
        private ProductTypesConfig $productTypesConfig,
        private EavConfig $eavConfig,
    ) {
    }

    public function getProductTypesConfig(): ProductTypesConfig
    {
        return $this->productTypesConfig;
    }

    public function getDefaultAttributeSetId(): int
    {
        return (int)$this->eavConfig->getEntityType('catalog_product')->getDefaultAttributeSetId();
    }
}
