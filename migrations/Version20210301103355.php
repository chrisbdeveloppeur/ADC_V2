<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210301103355 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app (id INT AUTO_INCREMENT NOT NULL, survey_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, rsdp VARCHAR(255) DEFAULT NULL, tpx INT DEFAULT NULL, position INT DEFAULT NULL, asset VARCHAR(255) DEFAULT NULL, balise VARCHAR(255) DEFAULT NULL, INDEX IDX_C96E70CFB3FE509D (survey_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE asset (id INT AUTO_INCREMENT NOT NULL, survey_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, `as` VARCHAR(255) DEFAULT NULL, ae VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, rsdp VARCHAR(255) DEFAULT NULL, tpx INT DEFAULT NULL, balise VARCHAR(255) DEFAULT NULL, INDEX IDX_2AF5A5CB3FE509D (survey_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cmdb (id INT AUTO_INCREMENT NOT NULL, survey_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, nb_action INT DEFAULT NULL, asset VARCHAR(255) DEFAULT NULL, rsdp VARCHAR(255) DEFAULT NULL, tpx INT DEFAULT NULL, balise VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, INDEX IDX_EAF57155B3FE509D (survey_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE other_action (id INT AUTO_INCREMENT NOT NULL, survey_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, rsdp VARCHAR(255) DEFAULT NULL, tpx INT DEFAULT NULL, position INT DEFAULT NULL, asset VARCHAR(255) DEFAULT NULL, balise VARCHAR(255) DEFAULT NULL, INDEX IDX_76CAB68AB3FE509D (survey_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE other_app (id INT AUTO_INCREMENT NOT NULL, survey_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, rsdp VARCHAR(255) DEFAULT NULL, tpx INT DEFAULT NULL, asset VARCHAR(255) DEFAULT NULL, balise VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, INDEX IDX_8BFA5C5CB3FE509D (survey_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE other_asset (id INT AUTO_INCREMENT NOT NULL, survey_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, `as` VARCHAR(255) DEFAULT NULL, ae VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, rsdp VARCHAR(255) DEFAULT NULL, tpx INT DEFAULT NULL, balise VARCHAR(255) DEFAULT NULL, INDEX IDX_6A1BADF2B3FE509D (survey_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phone (id INT AUTO_INCREMENT NOT NULL, survey_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, rsdp VARCHAR(255) DEFAULT NULL, tpx INT DEFAULT NULL, asset VARCHAR(255) DEFAULT NULL, balise VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, INDEX IDX_444F97DDB3FE509D (survey_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rdv (id INT AUTO_INCREMENT NOT NULL, survey_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, balise VARCHAR(255) DEFAULT NULL, INDEX IDX_10C31F86B3FE509D (survey_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE survey (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, service VARCHAR(255) DEFAULT NULL, resolve_method VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, cas_taskt VARCHAR(255) DEFAULT NULL, cas_inct VARCHAR(255) DEFAULT NULL, cas VARCHAR(255) DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, timestamp DATETIME NOT NULL, final_string LONGTEXT DEFAULT NULL, hashed_string VARCHAR(255) DEFAULT NULL, date_string DATETIME DEFAULT NULL, from_inct VARCHAR(255) DEFAULT NULL, type_inter VARCHAR(255) DEFAULT NULL, chemin LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', canceled TINYINT(1) DEFAULT NULL, rsdp VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, security_token VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app ADD CONSTRAINT FK_C96E70CFB3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)');
        $this->addSql('ALTER TABLE asset ADD CONSTRAINT FK_2AF5A5CB3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)');
        $this->addSql('ALTER TABLE cmdb ADD CONSTRAINT FK_EAF57155B3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)');
        $this->addSql('ALTER TABLE other_action ADD CONSTRAINT FK_76CAB68AB3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)');
        $this->addSql('ALTER TABLE other_app ADD CONSTRAINT FK_8BFA5C5CB3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)');
        $this->addSql('ALTER TABLE other_asset ADD CONSTRAINT FK_6A1BADF2B3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)');
        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_444F97DDB3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86B3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app DROP FOREIGN KEY FK_C96E70CFB3FE509D');
        $this->addSql('ALTER TABLE asset DROP FOREIGN KEY FK_2AF5A5CB3FE509D');
        $this->addSql('ALTER TABLE cmdb DROP FOREIGN KEY FK_EAF57155B3FE509D');
        $this->addSql('ALTER TABLE other_action DROP FOREIGN KEY FK_76CAB68AB3FE509D');
        $this->addSql('ALTER TABLE other_app DROP FOREIGN KEY FK_8BFA5C5CB3FE509D');
        $this->addSql('ALTER TABLE other_asset DROP FOREIGN KEY FK_6A1BADF2B3FE509D');
        $this->addSql('ALTER TABLE phone DROP FOREIGN KEY FK_444F97DDB3FE509D');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86B3FE509D');
        $this->addSql('DROP TABLE app');
        $this->addSql('DROP TABLE asset');
        $this->addSql('DROP TABLE cmdb');
        $this->addSql('DROP TABLE other_action');
        $this->addSql('DROP TABLE other_app');
        $this->addSql('DROP TABLE other_asset');
        $this->addSql('DROP TABLE phone');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('DROP TABLE survey');
        $this->addSql('DROP TABLE user');
    }
}
