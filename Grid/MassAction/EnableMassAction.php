<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Grid\MassAction;

use Yireo\LokiAdminComponents\Grid\MassAction\AbstractMassAction;

class EnableMassAction extends AbstractMassAction
{
    public function getLabel(): string
    {
        return 'Enable';
    }

    public function getUrl(): string
    {
        return $this->urlFactory->create()->getUrl('catalog/product/massStatus', ['status' => 1]);
    }
}
