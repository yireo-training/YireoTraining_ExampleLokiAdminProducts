<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Component\Form;

use Loki\AdminComponents\Component\Form\FormRepository as OriginalFormRepository;
use Loki\AdminComponents\Component\Form\FormViewModel as OriginalFormViewModel;
use Loki\AdminComponents\Form\Field\FieldType\View;
use Magento\Framework\Exception\LocalizedException;
use Override;

class FormRepository extends OriginalFormRepository
{
    #[Override]
    public function getPrimaryKey(): string
    {
        return 'entity_id';
    }

    /**
     * @throws LocalizedException
     */
    #[Override]
    public function saveValue(mixed $value): void
    {
        if (!is_array($value)) {
            return;
        }

        $item = $value['item'] ?? [];
        if (!is_array($item)) {
            return;
        }

        if ($this->getSubmittedId($item) !== $this->getRequestedId()) {
            throw new LocalizedException(
                __('The submitted product does not match the product being edited.')
            );
        }

        $value['item'] = array_intersect_key($item, array_flip($this->getAllowedProperties()));
        parent::saveValue($value);
    }

    private function getSubmittedId(array $item): int
    {
        return (int)($item[$this->getPrimaryKey()] ?? 0);
    }

    private function getRequestedId(): int
    {
        $block = $this->getComponent()->getViewModel()->getBlock();
        $idParam = (string)$block->getIdParam();
        if ($idParam === '') {
            $idParam = 'id';
        }

        return (int)$block->getRequest()->getParam($idParam);
    }

    /**
     * @return string[]
     */
    private function getAllowedProperties(): array
    {
        $allowedProperties = [$this->getPrimaryKey()];
        $viewModel = $this->getComponent()->getViewModel();
        if (false === $viewModel instanceof OriginalFormViewModel) {
            return $allowedProperties;
        }

        foreach ($viewModel->getFields() as $field) {
            if ($field->getData('field_type') instanceof View) {
                continue;
            }

            $allowedProperties[] = (string)$field->getCode();
        }

        return $allowedProperties;
    }
}
