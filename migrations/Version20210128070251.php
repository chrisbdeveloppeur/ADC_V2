<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210128070251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app ADD survey_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE app ADD CONSTRAINT FK_C96E70CFB3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)');
        $this->addSql('CREATE INDEX IDX_C96E70CFB3FE509D ON app (survey_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app DROP FOREIGN KEY FK_C96E70CFB3FE509D');
        $this->addSql('DROP INDEX IDX_C96E70CFB3FE509D ON app');
        $this->addSql('ALTER TABLE app DROP survey_id');
    }
}
