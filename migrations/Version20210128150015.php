<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210128150015 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE survey ADD service VARCHAR(255) DEFAULT NULL, ADD type VARCHAR(255) DEFAULT NULL, ADD cas_taskt VARCHAR(255) DEFAULT NULL, ADD cas_inct VARCHAR(255) DEFAULT NULL, ADD cas VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, ADD quantity INT NOT NULL, ADD duration INT NOT NULL, ADD proximity VARCHAR(255) NOT NULL, ADD meeting_respected TINYINT(1) DEFAULT NULL, ADD timestamp DATETIME NOT NULL, ADD final_string LONGTEXT DEFAULT NULL, ADD hashed_string VARCHAR(255) DEFAULT NULL, ADD date_string DATETIME DEFAULT NULL, ADD from_inct VARCHAR(255) DEFAULT NULL, ADD hostname VARCHAR(255) DEFAULT NULL, ADD new_user VARCHAR(255) DEFAULT NULL, ADD type_inter VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE survey DROP service, DROP type, DROP cas_taskt, DROP cas_inct, DROP cas, DROP description, DROP quantity, DROP duration, DROP proximity, DROP meeting_respected, DROP timestamp, DROP final_string, DROP hashed_string, DROP date_string, DROP from_inct, DROP hostname, DROP new_user, DROP type_inter');
    }
}
