<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220806061026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sporthall_permission (sporthall_id INT NOT NULL, permission_id INT NOT NULL, INDEX IDX_70EA9772CF43FCF4 (sporthall_id), INDEX IDX_70EA9772FED90CCA (permission_id), PRIMARY KEY(sporthall_id, permission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sporthall_permission ADD CONSTRAINT FK_70EA9772CF43FCF4 FOREIGN KEY (sporthall_id) REFERENCES sporthall (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sporthall_permission ADD CONSTRAINT FK_70EA9772FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sporthall_permission');
    }
}
