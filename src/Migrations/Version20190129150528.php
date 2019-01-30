<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190129150528 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trick ADD title VARCHAR(255) NOT NULL, ADD content LONGTEXT NOT NULL, ADD creation_date DATETIME NOT NULL, ADD modification_date DATETIME DEFAULT NULL, ADD category VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD trick_id INT DEFAULT NULL, ADD updated_trick_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AD473704 FOREIGN KEY (updated_trick_id) REFERENCES trick (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B281BE2E ON user (trick_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649AD473704 ON user (updated_trick_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trick DROP title, DROP content, DROP creation_date, DROP modification_date, DROP category');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B281BE2E');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AD473704');
        $this->addSql('DROP INDEX IDX_8D93D649B281BE2E ON user');
        $this->addSql('DROP INDEX IDX_8D93D649AD473704 ON user');
        $this->addSql('ALTER TABLE user DROP trick_id, DROP updated_trick_id');
    }
}
