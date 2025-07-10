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
                $this->formActionFactory->createCloseAction(),
                $this->formActionFactory->createDeleteAction(),
                $this->formActionFactory->createSaveContinueAction(),
                $this->formActionFactory->createSaveCloseAction(),
            ];
        }

        return [
            $this->formActionFactory->createCloseAction(),
            $this->formActionFactory->createSaveCloseAction(),
            //$this->formActionFactory->createSaveContinueAction(), // @todo: This looses current changes when creating a new item
        ];
    }
}
