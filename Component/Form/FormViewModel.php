<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Component\Form;

use Magento\Framework\DataObject;
use Loki\AdminComponents\Component\Form\FormViewModel as OriginalFormViewModel;

class FormViewModel extends OriginalFormViewModel
{
    public function getIndexUrl(): string
    {
        return $this->urlFactory->create()->getUrl('loki_admin_products/index/grid');
    }

    public function getFormActions(): array
    {
        $item = $this->getValue();
        if ($item instanceof DataObject && $item->getId() > 0) {
            return [
                $this->buttonFactory->createCloseAction(),
                $this->buttonFactory->createDeleteAction(),
                $this->buttonFactory->createSaveContinueAction(),
                $this->buttonFactory->createSaveCloseAction(),
            ];
        }

        return [
            $this->buttonFactory->createCloseAction(),
            $this->buttonFactory->createSaveCloseAction(),
            //$this->buttonFactory->createSaveContinueAction(), // @todo: This looses current changes when creating a new item
        ];
    }
}
