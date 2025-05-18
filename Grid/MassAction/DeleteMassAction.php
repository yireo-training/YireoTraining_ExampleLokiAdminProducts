<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Grid\MassAction;
use Yireo\LokiAdminComponents\Grid\MassAction\AbstractMassAction;

class DeleteMassAction extends AbstractMassAction
{
    public function getLabel(): string
    {
        return 'Delete';
    }

    public function getUrl(): string
    {
        return $this->urlFactory->create()->getUrl('catalog/product/massDelete');
    }
}
