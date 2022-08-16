<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220816132105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Delete ManyToOne between Parner and Sporthall';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E165D6EC8DC');
        $this->addSql('DROP INDEX IDX_312B3E165D6EC8DC ON partner');
        $this->addSql('ALTER TABLE partner DROP sporthalls_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner ADD sporthalls_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E165D6EC8DC FOREIGN KEY (sporthalls_id) REFERENCES sporthall (id)');
        $this->addSql('CREATE INDEX IDX_312B3E165D6EC8DC ON partner (sporthalls_id)');
    }
}