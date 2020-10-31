<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201031075919 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A1463301C60');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A1463301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A1463301C60');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A1463301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
    }
}
