<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Component\Form;

use Loki\AdminComponents\Component\Form\FormViewModel as OriginalFormViewModel;

class FormViewModel extends OriginalFormViewModel
{
    public function getIndexUrl(): string
    {
        return $this->urlFactory->create()->getUrl('loki_admin_products/index/grid');
    }
}
