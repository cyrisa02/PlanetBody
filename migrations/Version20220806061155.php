<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220806061155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sporthall_mailing (sporthall_id INT NOT NULL, mailing_id INT NOT NULL, INDEX IDX_A766FADDCF43FCF4 (sporthall_id), INDEX IDX_A766FADD3931AB76 (mailing_id), PRIMARY KEY(sporthall_id, mailing_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sporthall_mailing ADD CONSTRAINT FK_A766FADDCF43FCF4 FOREIGN KEY (sporthall_id) REFERENCES sporthall (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sporthall_mailing ADD CONSTRAINT FK_A766FADD3931AB76 FOREIGN KEY (mailing_id) REFERENCES mailing (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sporthall_mailing');
    }
}
