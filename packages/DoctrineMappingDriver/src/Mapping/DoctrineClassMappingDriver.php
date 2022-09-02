<?php

declare(strict_types=1);

namespace Sacred\Packages\DoctrineMappingDriver\Mapping;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata as OrmClassMetadata;
use Doctrine\ORM\Mapping\MappingException;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Doctrine\Persistence\Mapping\Driver\MappingDriver;
use LogicException;
use Symfony\Component\Finder\Finder;
use Symfony\Contracts\Cache\CacheInterface;
use function Safe\file_get_contents;
use function Safe\preg_match;

class DoctrineClassMappingDriver implements MappingDriver
{
    /** @phpstan-var array<class-string, class-string<DoctrineClassMappingConfigurator>> */
    private array $configuratorClassMap = [];
    /** @var array<string> */
    private array $paths;
    private CacheInterface $cache;

    /**
     * @param array<string> $paths
     */
    public function __construct(array $paths, CacheInterface $cache)
    {
        $this->paths = $paths;
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     */
    public function loadMetadataForClass($className, ClassMetadata $metadata): void
    {
        $this->init();
        if (!$metadata instanceof OrmClassMetadata) {
            throw new LogicException();
        }

        $configuratorClass = $this->configuratorClassMap[$className] ?? throw MappingException::classIsNotAValidEntityOrMappedSuperClass($className);
        $configurator = new $configuratorClass();
        $configurator->configure(new ClassMetadataBuilder($metadata));
    }

    /**
     * {@inheritDoc}
     */
    public function getAllClassNames(): array
    {
        $this->init();
        return array_keys($this->configuratorClassMap);
    }

    /**
     * {@inheritDoc}
     */
    public function isTransient($className): bool
    {
        $this->init();
        return !isset($this->configuratorClassMap[$className]);
    }

    private function init(): void
    {
        if ($this->configuratorClassMap !== []) {
            return;
        }

        $this->configuratorClassMap = $this->cache->get('DoctrineClassMappingDriver', function (): array {
            $result = [];
            foreach (Finder::create()->in($this->paths)->name('*.php')->files() as $path => $file) {
                $content = file_get_contents($path);
                preg_match('/^namespace (.*);$/m', $content, $m);
                $configuratorClassName = $m[1] . '\\' . $file->getBasename('.php');
                if (!is_a($configuratorClassName, DoctrineClassMappingConfigurator::class, true)) {
                    throw new LogicException();
                }

                $result[$configuratorClassName::getClassName()] = $configuratorClassName;
            }
            return $result;
        });
    }
}
