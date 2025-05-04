<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Util;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Ui\Api\BookmarkRepositoryInterface;
use Magento\Ui\Api\Data\BookmarkInterface;

// @todo: Move this to Yireo_LokiAdminComponents when ready
class BookmarkLoader
{
    public function __construct(
        private BookmarkRepositoryInterface $bookmarkRepository,
        private SearchCriteriaBuilder $searchCriteriaBuilder,
    ) {
    }

    public function getBookmarkData(): array
    {
        $this->searchCriteriaBuilder->addFilter('namespace', 'product_listing');
        $searchResults = $this->bookmarkRepository->getList($this->searchCriteriaBuilder->create());

        if ($searchResults->getTotalCount() === 0) {
            return [];
        }

        foreach ($searchResults->getItems() as $bookmark) {
            if ($bookmark->isCurrent()) {
                return $this->getDataFromBookmark($bookmark);
            }
        }

        foreach ($searchResults->getItems() as $bookmark) {
            if ($bookmark->getIdentifier() === 'default') {
                return $this->getDataFromBookmark($bookmark);
            }
        }

        return [];
    }

    private function getDataFromBookmark(BookmarkInterface $bookmark): array
    {
        return $bookmark->getConfig();
    }
}
