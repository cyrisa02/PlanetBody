<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220809093826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Delete relation between Maincustomer and Partner';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maincustomer DROP FOREIGN KEY FK_13AC69DBDE7F1C6');
        $this->addSql('DROP INDEX IDX_13AC69DBDE7F1C6 ON maincustomer');
        $this->addSql('ALTER TABLE maincustomer DROP partners_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maincustomer ADD partners_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE maincustomer ADD CONSTRAINT FK_13AC69DBDE7F1C6 FOREIGN KEY (partners_id) REFERENCES partner (id)');
        $this->addSql('CREATE INDEX IDX_13AC69DBDE7F1C6 ON maincustomer (partners_id)');
    }
}