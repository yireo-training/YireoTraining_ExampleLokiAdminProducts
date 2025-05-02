<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Component\Grid;

use Magento\Framework\DataObject;
use Magento\Framework\UrlFactory;
use Yireo\LokiAdminComponents\Component\Grid\GridViewModel as OriginalGridViewModel;
use Yireo\LokiAdminComponents\Grid\Cell\CellActionFactory;
use Yireo\LokiAdminComponents\Grid\State;
use Yireo\LokiComponents\Util\CamelCaseConvertor;
use YireoTraining\ExampleLokiAdminProducts\Util\ColumnLoader;

class GridViewModel extends OriginalGridViewModel
{
    public function __construct(
        State $state,
        UrlFactory $urlFactory,
        CellActionFactory $cellActionFactory,
        CamelCaseConvertor $camelCaseConvertor,
        private ColumnLoader $columnLoader,
    ) {
        parent::__construct($state, $urlFactory, $cellActionFactory, $camelCaseConvertor);
    }

    public function getIndexUrl(): string
    {
        return $this->urlFactory->create()->getUrl('softwareproducttype/index/grid');
    }

    public function getNewUrl(): string
    {
        return $this->urlFactory->create()->getUrl('softwareproducttype/index/form');
    }

    public function getColumns(): array
    {
        return $this->columnLoader->getColumns();
    }

    public function getCellActions(DataObject $item): array
    {
        $cellActions = [];

        $editUrl = $this->urlFactory->create()->getUrl('softwareproducttype/index/form', [
            'id' => $item->getId(),
        ]);

        $cellActions[] = $this->cellActionFactory->create($editUrl, 'Edit');

        return $cellActions;
    }
}
