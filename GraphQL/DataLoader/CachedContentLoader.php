<?php
namespace BD\EzPlatformGraphQLBundle\GraphQL\DataLoader;

use BD\EzPlatformGraphQLBundle\GraphQL\DataLoader\Exception\NotFoundException\NotFoundException;
use eZ\Publish\API\Repository\Exceptions as ApiException;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\Content;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Search\SearchHit;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;

class CachedContentLoader implements ContentLoader
{
    /**
     * @var ContentLoader
     */
    private $innerLoader;

    private $loadedItems = [];

    public function __construct(ContentLoader $innerLoader)
    {
        $this->innerLoader = $innerLoader;
    }

    public function find(Query $query): array
    {
        $items = $this->innerLoader->find($query);

        foreach ($items as $item) {
            $this->loadedItems[$item->id] = $item;
        }

        return $items;
    }

    public function findSingle(Criterion $filter): Content
    {
        $contentId = $filter->value[0];
        if ($filter instanceof Criterion\ContentId && isset($this->loadedItems[$contentId])) {
            return $this->loadedItems[$contentId];
        }

        $item = $this->innerLoader->findSingle($filter);
        $this->loadedItems[$item->id] = $item;

        return $item;
    }
}