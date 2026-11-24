<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Test\Integration\Component\Grid;

use Magento\Catalog\Test\Fixture\Product as ProductFixture;
use Magento\TestFramework\Fixture\AppArea;
use Magento\TestFramework\Fixture\DataFixture;
use Magento\TestFramework\Fixture\DataFixtureStorageManager;
use Magento\TestFramework\TestCase\AbstractBackendController;
use YireoTraining\ExampleLokiAdminProducts\Test\Integration\Traits\DispatchLokiUpdate;

#[AppArea('adminhtml')]
class GridRepositoryTest extends AbstractBackendController
{
    use DispatchLokiUpdate;

    #[DataFixture(ProductFixture::class, ['name' => 'Original name'], as: 'product')]
    public function testSavesInlineEdit(): void
    {
        $productId = $this->getFixtureProductId();

        $this->dispatchInlineEdit($productId, 'Changed name');

        $this->assertSame('Changed name', $this->reloadProduct($productId)->getName());
    }

    #[DataFixture(ProductFixture::class, ['name' => 'Original name'], as: 'product')]
    public function testRefusesInlineEditWithoutProductsAcl(): void
    {
        $productId = $this->getFixtureProductId();
        $this->denyProductsAcl();

        $this->dispatchInlineEdit($productId, 'Changed name');

        $this->assertSame('Original name', $this->reloadProduct($productId)->getName());
    }

    private function dispatchInlineEdit(int $productId, string $value): void
    {
        $this->dispatchLokiUpdate('loki_admin_products_index_grid', 'loki_admin_products.grid', [
            'inline_edit' => [
                'identifier' => $productId,
                'property' => 'name',
                'value' => $value,
            ],
        ]);
    }

    private function getFixtureProductId(): int
    {
        return (int)DataFixtureStorageManager::getStorage()->get('product')->getId();
    }
}
