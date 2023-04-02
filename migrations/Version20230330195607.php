<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330195607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('rating_types');
        $table->addColumn('created', Types::DATETIME_MUTABLE);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('rating_types');
        $table->dropColumn('created');
    }
}
