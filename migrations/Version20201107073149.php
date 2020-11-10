<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201107073149 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE price_config (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE default_day ADD price_config_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE default_day ADD CONSTRAINT FK_CBC75ABDA76A357F FOREIGN KEY (price_config_id) REFERENCES price_config (id)');
        $this->addSql('CREATE INDEX IDX_CBC75ABDA76A357F ON default_day (price_config_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE default_day DROP FOREIGN KEY FK_CBC75ABDA76A357F');
        $this->addSql('DROP TABLE price_config');
        $this->addSql('DROP INDEX IDX_CBC75ABDA76A357F ON default_day');
        $this->addSql('ALTER TABLE default_day DROP price_config_id');
    }
}
