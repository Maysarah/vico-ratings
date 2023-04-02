<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330220713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('project_ratings');
        $table->addColumn('id', Types::INTEGER)
            ->setUnsigned(true)
            ->setAutoincrement(true);

        $table->addColumn('project_id',Types::INTEGER);
        $table->addColumn('rating_type_id',Types::INTEGER)->setUnsigned(true);

        $table->addForeignKeyConstraint('project',['project_id'],['id']);
        $table->addForeignKeyConstraint('rating_types',['rating_type_id'], ['id']);

        $table->addColumn('rating', Types::SMALLINT)->setNotnull(true);
        $table->addColumn('client_note', Types::TEXT)->setNotnull(false);
        $table->addColumn('created', Types::DATETIME_MUTABLE);
        $table->addColumn('updated', Types::DATETIME_MUTABLE);

        $table->setPrimaryKey(['id']);

    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('project_ratings');
    }
}
