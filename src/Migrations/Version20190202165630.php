<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190202165630 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trick ADD created_by_id INT NOT NULL, ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91EB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D8F0A91EB03A8386 ON trick (created_by_id)');
        $this->addSql('CREATE INDEX IDX_D8F0A91E896DBBDE ON trick (updated_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91EB03A8386');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E896DBBDE');
        $this->addSql('DROP INDEX IDX_D8F0A91EB03A8386 ON trick');
        $this->addSql('DROP INDEX IDX_D8F0A91E896DBBDE ON trick');
        $this->addSql('ALTER TABLE trick DROP created_by_id, DROP updated_by_id');
    }
}
