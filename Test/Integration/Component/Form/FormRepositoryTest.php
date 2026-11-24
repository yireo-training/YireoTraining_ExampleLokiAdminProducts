<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Test\Integration\Component\Form;

use Magento\Catalog\Test\Fixture\Product as ProductFixture;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\TestFramework\Fixture\AppArea;
use Magento\TestFramework\Fixture\DataFixture;
use Magento\TestFramework\Fixture\DataFixtureStorageManager;
use Magento\TestFramework\TestCase\AbstractBackendController;
use YireoTraining\ExampleLokiAdminProducts\Test\Integration\Traits\DispatchLokiUpdate;

#[AppArea('adminhtml')]
class FormRepositoryTest extends AbstractBackendController
{
    use DispatchLokiUpdate;

    private const HANDLE = 'loki_admin_products_index_form';
    private const BLOCK_NAME = 'loki_admin_products.form';

    #[DataFixture(ProductFixture::class, ['name' => 'Original name'], as: 'product')]
    public function testSavesOnlyDeclaredFields(): void
    {
        $productId = $this->getFixtureProductId('product');

        $this->dispatchSave($productId, $productId, [
            'name' => 'Changed name',
            'type_id' => 'virtual',
        ]);

        $product = $this->reloadProduct($productId);
        $this->assertSame('Changed name', $product->getName());
        $this->assertSame('simple', $product->getTypeId());
    }

    #[DataFixture(ProductFixture::class, ['name' => 'Original name'], as: 'product')]
    #[DataFixture(ProductFixture::class, ['name' => 'Other name'], as: 'other')]
    public function testRefusesSavingAnotherProductThanRequested(): void
    {
        $productId = $this->getFixtureProductId('product');
        $otherProductId = $this->getFixtureProductId('other');

        $this->dispatchSave($productId, $otherProductId, ['name' => 'Changed name']);

        $this->assertSame('Other name', $this->reloadProduct($otherProductId)->getName());
        $this->assertSame('Original name', $this->reloadProduct($productId)->getName());
    }

    #[DataFixture(ProductFixture::class, ['name' => 'Original name'], as: 'product')]
    public function testRefusesSaveWithoutProductsAcl(): void
    {
        $productId = $this->getFixtureProductId('product');
        $this->denyProductsAcl();

        $this->dispatchSave($productId, $productId, ['name' => 'Changed name']);

        $this->assertSame('Original name', $this->reloadProduct($productId)->getName());
    }

    #[DataFixture(ProductFixture::class, as: 'product')]
    public function testRefusesDeleteWithoutProductsAcl(): void
    {
        $productId = $this->getFixtureProductId('product');
        $this->denyProductsAcl();

        $this->dispatchLokiUpdate(self::HANDLE, self::BLOCK_NAME, [
            'actions' => ['delete'],
            'item' => ['entity_id' => $productId],
        ], ['id' => $productId]);

        $this->assertSame($productId, (int)$this->reloadProduct($productId)->getId());
    }

    #[DataFixture(ProductFixture::class, as: 'product')]
    public function testDeletesRequestedProduct(): void
    {
        $productId = $this->getFixtureProductId('product');

        $this->dispatchLokiUpdate(self::HANDLE, self::BLOCK_NAME, [
            'actions' => ['delete'],
            'item' => ['entity_id' => $productId],
        ], ['id' => $productId]);

        $this->expectException(NoSuchEntityException::class);
        $this->reloadProduct($productId);
    }

    #[DataFixture(ProductFixture::class, as: 'product')]
    #[DataFixture(ProductFixture::class, as: 'other')]
    public function testRefusesDeletingAnotherProductThanRequested(): void
    {
        $productId = $this->getFixtureProductId('product');
        $otherProductId = $this->getFixtureProductId('other');

        $this->dispatchLokiUpdate(self::HANDLE, self::BLOCK_NAME, [
            'actions' => ['delete'],
            'item' => ['entity_id' => $otherProductId],
        ], ['id' => $productId]);

        $this->assertSame($otherProductId, (int)$this->reloadProduct($otherProductId)->getId());
    }

    private function dispatchSave(int $requestedId, int $submittedId, array $data): void
    {
        $this->dispatchLokiUpdate(self::HANDLE, self::BLOCK_NAME, [
            'actions' => ['save'],
            'item' => ['entity_id' => $submittedId, ...$data],
        ], ['id' => $requestedId]);
    }

    private function getFixtureProductId(string $name): int
    {
        return (int)DataFixtureStorageManager::getStorage()->get($name)->getId();
    }
}
