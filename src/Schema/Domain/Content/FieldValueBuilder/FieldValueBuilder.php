<?php
namespace EzSystems\EzPlatformGraphQL\Schema\Domain\Content\FieldValueBuilder;

use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;

interface FieldValueBuilder
{
    /**
     * @param FieldDefinition $fieldDefinition
     * @return array GraphQL definition array for the Field Value
     */
    public function buildDefinition(FieldDefinition $fieldDefinition);
}