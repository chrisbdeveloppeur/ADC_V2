<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210106092636 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE survey ADD user_id INT DEFAULT NULL, ADD hostname VARCHAR(255) DEFAULT NULL, ADD new_user VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE survey ADD CONSTRAINT FK_AD5F9BFCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AD5F9BFCA76ED395 ON survey (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B3FE509D');
        $this->addSql('DROP INDEX UNIQ_8D93D649B3FE509D ON user');
        $this->addSql('ALTER TABLE user ADD security_token VARCHAR(255) NOT NULL, ADD is_verified TINYINT(1) NOT NULL, DROP survey_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE survey DROP FOREIGN KEY FK_AD5F9BFCA76ED395');
        $this->addSql('DROP INDEX UNIQ_AD5F9BFCA76ED395 ON survey');
        $this->addSql('ALTER TABLE survey DROP user_id, DROP hostname, DROP new_user');
        $this->addSql('ALTER TABLE user ADD survey_id INT DEFAULT NULL, DROP security_token, DROP is_verified');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649B3FE509D ON user (survey_id)');
    }
}
