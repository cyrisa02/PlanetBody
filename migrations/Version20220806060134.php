<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220806060134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner ADD maincustomer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E16C82647E8 FOREIGN KEY (maincustomer_id) REFERENCES maincustomer (id)');
        $this->addSql('CREATE INDEX IDX_312B3E16C82647E8 ON partner (maincustomer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E16C82647E8');
        $this->addSql('DROP INDEX IDX_312B3E16C82647E8 ON partner');
        $this->addSql('ALTER TABLE partner DROP maincustomer_id');
    }
}
