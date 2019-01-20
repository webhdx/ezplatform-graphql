<?php
namespace BD\EzPlatformGraphQLBundle\GraphQL\DataLoader;

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\ContentType\ContentType;

interface ContentTypeLoader
{
    public function load($contentTypeId): ContentType;

    public function loadByIdentifier($identifier): ContentType;
}