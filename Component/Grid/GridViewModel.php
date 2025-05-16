<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Component\Grid;

use Magento\Framework\DataObject;
use Override;
use Yireo\LokiAdminComponents\Component\Grid\GridViewModel as OriginalGridViewModel;
use Yireo\LokiAdminComponents\Grid\Cell\CellAction;

class GridViewModel extends OriginalGridViewModel
{
    #[Override]
    public function getIndexUrl(): string
    {
        return $this->urlFactory->create()->getUrl('loki_admin_products/index/grid');
    }

    #[Override]
    public function getNewUrl(): string
    {
        return $this->urlFactory->create()->getUrl('loki_admin_products/index/form');
    }

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
    protected function getAdditionalActions(DataObject $item): array
    {
        $cellActions = [];

        $editUrl = $this->urlFactory->create()->getUrl('loki_admin_products/index/form', [
            'id' => $item->getId(),
        ]);

        $cellActions[] = $this->cellActionFactory->create($editUrl, 'Quick Edit');

        return $cellActions;
    }
}
