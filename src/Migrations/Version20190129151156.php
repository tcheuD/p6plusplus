<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190129151156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trick ADD comment_id INT DEFAULT NULL, ADD picture_id INT DEFAULT NULL, ADD video_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91EF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91EEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('CREATE INDEX IDX_D8F0A91EF8697D13 ON trick (comment_id)');
        $this->addSql('CREATE INDEX IDX_D8F0A91EEE45BDBF ON trick (picture_id)');
        $this->addSql('CREATE INDEX IDX_D8F0A91E29C1004E ON trick (video_id)');
        $this->addSql('ALTER TABLE video ADD number INT NOT NULL, ADD platform VARCHAR(255) NOT NULL, ADD creation_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE comment ADD comment_date DATETIME NOT NULL, ADD comment LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE user ADD comment_id INT DEFAULT NULL, ADD picture_id INT DEFAULT NULL, ADD video_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64929C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649F8697D13 ON user (comment_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649EE45BDBF ON user (picture_id)');
        $this->addSql('CREATE INDEX IDX_8D93D64929C1004E ON user (video_id)');
        $this->addSql('ALTER TABLE picture ADD number INT NOT NULL, ADD url VARCHAR(255) NOT NULL, ADD creation_date DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP comment_date, DROP comment');
        $this->addSql('ALTER TABLE picture DROP number, DROP url, DROP creation_date');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91EF8697D13');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91EEE45BDBF');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E29C1004E');
        $this->addSql('DROP INDEX IDX_D8F0A91EF8697D13 ON trick');
        $this->addSql('DROP INDEX IDX_D8F0A91EEE45BDBF ON trick');
        $this->addSql('DROP INDEX IDX_D8F0A91E29C1004E ON trick');
        $this->addSql('ALTER TABLE trick DROP comment_id, DROP picture_id, DROP video_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F8697D13');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EE45BDBF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64929C1004E');
        $this->addSql('DROP INDEX IDX_8D93D649F8697D13 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649EE45BDBF ON user');
        $this->addSql('DROP INDEX IDX_8D93D64929C1004E ON user');
        $this->addSql('ALTER TABLE user DROP comment_id, DROP picture_id, DROP video_id');
        $this->addSql('ALTER TABLE video DROP number, DROP platform, DROP creation_date');
    }
}
