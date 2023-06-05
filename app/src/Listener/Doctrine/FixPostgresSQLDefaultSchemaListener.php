<?php

declare(strict_types=1);

namespace App\Listener\Doctrine;

use Doctrine\DBAL\Schema\PostgreSQLSchemaManager;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;

final class FixPostgresSQLDefaultSchemaListener
{
    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function postGenerateSchema(GenerateSchemaEventArgs $args): void
    {
        $schemaManager = $args
            ->getEntityManager()
            ->getConnection()
            ->createSchemaManager();

        /*
         * @psalm-suppress RedundantCondition
         */
        if (!$schemaManager instanceof PostgreSQLSchemaManager) {
            return;
        }

        /*
         * @psalm-suppress InternalMethod
         */
        foreach ($schemaManager->getExistingSchemaSearchPaths() as $namespace) {
            if (!$args->getSchema()->hasNamespace($namespace)) {
                $args->getSchema()->createNamespace($namespace);
            }
        }
    }
}
