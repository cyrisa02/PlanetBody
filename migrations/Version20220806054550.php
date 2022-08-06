<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220806054550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mailing ADD categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE mailing ADD CONSTRAINT FK_3ED9315EA21214B7 FOREIGN KEY (categories_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_3ED9315EA21214B7 ON mailing (categories_id)');
        $this->addSql('ALTER TABLE partner ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E16A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_312B3E16A76ED395 ON partner (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mailing DROP FOREIGN KEY FK_3ED9315EA21214B7');
        $this->addSql('DROP INDEX IDX_3ED9315EA21214B7 ON mailing');
        $this->addSql('ALTER TABLE mailing DROP categories_id');
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E16A76ED395');
        $this->addSql('DROP INDEX IDX_312B3E16A76ED395 ON partner');
        $this->addSql('ALTER TABLE partner DROP user_id');
    }
}
