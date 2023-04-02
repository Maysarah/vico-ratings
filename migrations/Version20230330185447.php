<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330185447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('rating_types');
        $table->addColumn('id', Types::INTEGER)
            ->setUnsigned(true)
            ->setAutoincrement(true);
        $table->addColumn('code', Types::STRING, ['length' => 255]);
        $table->addColumn('display', Types::STRING, ['length' => 255]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['code']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('rating_types');
    }
}
