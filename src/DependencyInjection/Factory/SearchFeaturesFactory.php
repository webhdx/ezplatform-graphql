<?php
namespace EzSystems\EzPlatformGraphQL\DependencyInjection\Factory;

use eZ\Bundle\EzPublishCoreBundle\ApiLoader\RepositoryConfigurationProvider;

class SearchFeaturesFactory
{
    /**
     * @var \eZ\Bundle\EzPublishCoreBundle\ApiLoader\RepositoryConfigurationProvider
     */
    private $configurationProvider;

    /**
     * @var \EzSystems\EzPlatformGraphQL\Search\SearchFeatures[]
     */
    private $searchFeatures = [];

    public function __construct(RepositoryConfigurationProvider $configurationProvider, array $searchFeatures)
    {
        $this->configurationProvider = $configurationProvider;
        $this->searchFeatures = $searchFeatures;
    }

    public function build()
    {
        $searchEngine = $this->configurationProvider->getRepositoryConfig()['search']['engine'];

        if (isset($this->searchFeatures[$searchEngine])) {
            return $this->searchFeatures[$searchEngine];
        } else {
            throw new \InvalidArgumentException("Search engine not found");
        }
    }
}