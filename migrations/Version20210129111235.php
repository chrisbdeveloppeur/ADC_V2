<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210129111235 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asset ADD `as` VARCHAR(255) DEFAULT NULL, ADD ae VARCHAR(255) DEFAULT NULL, DROP current_hostname, DROP new_hostname');
        $this->addSql('ALTER TABLE other_asset ADD `as` VARCHAR(255) DEFAULT NULL, ADD ae VARCHAR(255) DEFAULT NULL, DROP current_hostname, DROP new_hostname');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asset ADD current_hostname VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD new_hostname VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP `as`, DROP ae');
        $this->addSql('ALTER TABLE other_asset ADD current_hostname VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD new_hostname VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP `as`, DROP ae');
    }
}
