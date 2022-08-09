<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220809092826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Delete the relation ManyToOne between User and Sporthall';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495D6EC8DC');
        $this->addSql('DROP INDEX IDX_8D93D6495D6EC8DC ON user');
        $this->addSql('ALTER TABLE user DROP sporthalls_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD sporthalls_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495D6EC8DC FOREIGN KEY (sporthalls_id) REFERENCES sporthall (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495D6EC8DC ON user (sporthalls_id)');
    }
}