<?php
namespace BD\EzPlatformGraphQLBundle\GraphQL\DataLoader;

use BD\EzPlatformGraphQLBundle\GraphQL\DataLoader\Exception\NotFoundException\NotFoundException;
use eZ\Publish\API\Repository\Exceptions as ApiException;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\Content;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Search\SearchHit;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;

class SearchContentLoader implements ContentLoader
{
    /**
     * @var SearchService
     */
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * Loads a list of content items given a Query Criterion.
     *
     * @param Query $query A Query Criterion. To use multiple criteria, group them with a LogicalAnd.
     * @return \eZ\Publish\API\Repository\Values\Content\Content[]
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     */
    public function find(Query $query): array
    {
        return array_map(
            function (SearchHit $searchHit) {
                return $searchHit->valueObject;
            },
            $this->searchService->findContent($query)->searchHits
        );
    }

    /**
     * Loads a single content item given a Query Criterion.
     *
     * @param Criterion $filter A Query Criterion. Use Criterion\ContentId, Criterion\RemoteId or Criterion\LocationId for basic loading.
     * @return \eZ\Publish\API\Repository\Values\Content\Content
     *
     * @throws NotFoundException
     */
    public function findSingle(Criterion $filter): Content
    {
        try {
            return $this->searchService->findSingle($filter);
        } catch (ApiException\InvalidArgumentException $e) {
        } catch (ApiException\NotFoundException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }
}