<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210128145157 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asset ADD survey_id INT DEFAULT NULL, ADD current_hostname VARCHAR(255) DEFAULT NULL, ADD new_hostname VARCHAR(255) DEFAULT NULL, ADD type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE asset ADD CONSTRAINT FK_2AF5A5CB3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)');
        $this->addSql('CREATE INDEX IDX_2AF5A5CB3FE509D ON asset (survey_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asset DROP FOREIGN KEY FK_2AF5A5CB3FE509D');
        $this->addSql('DROP INDEX IDX_2AF5A5CB3FE509D ON asset');
        $this->addSql('ALTER TABLE asset DROP survey_id, DROP current_hostname, DROP new_hostname, DROP type');
    }
}
