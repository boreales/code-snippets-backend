<?php

declare(strict_types=1);

// src/DataProvider/WebsiteCollectionDataProvider.php

namespace App\DataProviders;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Repository\WebsiteRepository;
use Symfony\Bundle\SecurityBundle\Security;

class WebsiteCollectionDataProvider implements ProviderInterface
{
    private $websiteRepository;
    private $security;

    public function __construct(WebsiteRepository $websiteRepository, Security $security)
    {
        $this->websiteRepository = $websiteRepository;
        $this->security = $security;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|null|object
    {
        return $this->websiteRepository->findBy(['user' => $this->security->getUser()]);
    }
}

