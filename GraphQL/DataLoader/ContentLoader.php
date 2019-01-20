<?php
namespace BD\EzPlatformGraphQLBundle\GraphQL\DataLoader;

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;

interface ContentLoader
{
    /**
     * Loads a list of content items given a Query Criterion.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Query $query
     * @return \eZ\Publish\API\Repository\Values\Content\Content[]
     */
    public function find(Query $query): array;

    /**
     * Loads a single content item given a Query Criterion.
     *
     * @param Criterion $criterion A Query Criterion.
     *        Use Criterion\ContentId, Criterion\RemoteId or Criterion\LocationId for basic loading.
     * @return \eZ\Publish\API\Repository\Values\Content\Content
     */
    public function findSingle(Criterion $criterion);
}