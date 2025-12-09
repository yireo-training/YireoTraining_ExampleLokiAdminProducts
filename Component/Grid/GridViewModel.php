<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Component\Grid;

use Magento\Framework\DataObject;
use Override;
use Loki\AdminComponents\Component\Grid\GridViewModel as OriginalGridViewModel;
use Loki\AdminComponents\Grid\Cell\CellAction;

/**
 * @method GridContext getContext()
 */
class GridViewModel extends OriginalGridViewModel
{

    #[Override]
    public function getRowAction(DataObject $item): CellAction
    {
        $editUrl = $this->urlFactory->create()->getUrl('catalog/product/edit', [
            'id' => $item->getId(),
        ]);

        return $this->cellActionFactory->create($editUrl, 'Edit');
    }

    #[Override]
    public function getSearchableFields(): array
    {
        return [
            'name',
            'description',
            'short_description',
        ];
    }

    #[Override]
    public function getButtons(): array
    {
        $subButtons = [];
        $attributeSetId = $this->getContext()->getDefaultAttributeSetId();

        foreach ($this->getContext()->getProductTypesConfig()->getAll() as $productType) {
            $params = ['set' => $attributeSetId, 'type' => $productType['name']];
            $url = $this->urlFactory->create()->getUrl('catalog/product/new', $params);
            $subButtons[] = $this->buttonFactory->createLinkAction(
                $url,
                $productType['label']
            );
        }

        $params = ['set' => $attributeSetId, 'type' => 'simple'];
        $url = $this->urlFactory->create()->getUrl('catalog/product/new', $params);
        $button = $this->buttonFactory->createLinkAction(
            $url,
            'Add Product',
            subButtons: $subButtons,
            primary: true
        );

        return [$button];
    }

    #[Override]
    protected function getAdditionalActions(DataObject $item): array
    {
        $cellActions = [];

        $editUrl = $this->urlFactory->create()->getUrl('loki_admin_products/index/form', [
            'id' => $item->getId(),
        ]);

        $cellActions[] = $this->cellActionFactory->create('Quick Edit', $editUrl);

        return $cellActions;
    }
}
