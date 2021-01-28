<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210128210917 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app ADD balise VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE asset ADD balise VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE other_asset ADD balise VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app DROP balise');
        $this->addSql('ALTER TABLE asset DROP balise');
        $this->addSql('ALTER TABLE other_asset DROP balise');
    }
}
