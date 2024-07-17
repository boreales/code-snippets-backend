<?php

declare(strict_types=1);

// src/DataProvider/WebsiteCollectionDataProvider.php

namespace App\DataProviders;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Repository\SnippetRepository;
use Symfony\Bundle\SecurityBundle\Security;

class SnippetCollectionDataProvider implements ProviderInterface
{
    private $snippetRepository;
    private $security;

    public function __construct(SnippetRepository $snippetRepository, Security $security)
    {
        $this->snippetRepository = $snippetRepository;
        $this->security = $security;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|null|object
    {
        return $this->snippetRepository->findBy(['user' => $this->security->getUser()]);
    }
}

