<?php
namespace EzSystems\EzPlatformGraphQL\Schema\Domain\Content\Worker\FieldDefinition;

use eZ\Publish\API\Repository\Values\ContentType\ContentType;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;
use EzSystems\EzPlatformGraphQL\Schema\Builder;
use EzSystems\EzPlatformGraphQL\Schema\Domain\Content\Worker\BaseWorker;
use EzSystems\EzPlatformGraphQL\Schema\Worker;
use EzSystems\EzPlatformGraphQL\Search\SearchFeatures;

/**
 * Adds the field definition, if it is searchable, as a filter on the type's collection.
 */
class AddFieldDefinitionToCollectionFilters extends BaseWorker implements Worker
{
    /**
     * @var SearchFeatures
     */
    private $searchFeatures;

    public function __construct(SearchFeatures $searchFeatures)
    {
        $this->searchFeatures = $searchFeatures;
    }

    public function work(Builder $schema, array $args)
    {
        $domainGroupName = $this->getNameHelper()->domainGroupName($args['ContentTypeGroup']);
        $domainContentCollectionField = $this->getNameHelper()->domainContentCollectionField($args['ContentType']);
        $fieldDefinitionField = $this->getNameHelper()->fieldDefinitionField($args['FieldDefinition']);

        $schema->addFieldToType(
            $domainGroupName,
            new Builder\Input\Field(
                $domainContentCollectionField,
                $this->getFilterType($args['FieldDefinition']),
                ['description' => 'Filter content based on the ' . $args['FieldDefinition']->identifier . ' field']
            )
        );
    }

    public function canWork(Builder $schema, array $args)
    {
        return
            isset($args['FieldDefinition'])
            && $args['FieldDefinition'] instanceof FieldDefinition
            & isset($args['ContentType'])
            && $args['ContentType'] instanceof ContentType
            && $this->searchFeatures->supportsFieldCriterion($args['FieldDefinition']);
    }

    /**
     * @param ContentType $contentType
     * @return string
     */
    protected function getDomainContentName(ContentType $contentType): string
    {
        return $this->getNameHelper()->domainContentName($contentType);
    }

    /**
     * @param FieldDefinition $fieldDefinition
     * @return string
     */
    protected function getFieldDefinitionField(FieldDefinition $fieldDefinition): string
    {
        return $this->getNameHelper()->fieldDefinitionField($fieldDefinition);
    }

    private function isSearchable(FieldDefinition $fieldDefinition): bool
    {
        return $fieldDefinition->isSearchable
            // should only be verified if legacy is the current search engine
            && $this->converterRegistry->getConverter($fieldDefinition->fieldTypeIdentifier)->getIndexColumn() !== false;
    }

    private function getFilterType(FieldDefinition $fieldDefinition)
    {
        switch ($fieldDefinition->fieldTypeIdentifier)
        {
            case 'ezboolean':
                return 'Boolean';
            default:
                return 'String';
        }
    }
}