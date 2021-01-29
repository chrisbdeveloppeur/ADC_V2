<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210129123654 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE other_app (id INT AUTO_INCREMENT NOT NULL, survey_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, rsdp VARCHAR(255) DEFAULT NULL, tpx INT DEFAULT NULL, asset VARCHAR(255) DEFAULT NULL, balise VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, INDEX IDX_8BFA5C5CB3FE509D (survey_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE other_app ADD CONSTRAINT FK_8BFA5C5CB3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE other_app');
    }
}
