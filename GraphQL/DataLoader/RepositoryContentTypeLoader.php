<?php
namespace BD\EzPlatformGraphQLBundle\GraphQL\DataLoader;

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\ContentType\ContentType;

class RepositoryContentTypeLoader implements ContentTypeLoader
{
    public function load($contentTypeId): ContentType
    {

    }

    public function loadByIdentifier($identifier): ContentType
    {

    }
}