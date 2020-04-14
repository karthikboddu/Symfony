<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200224055140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_post_upload ADD fk_user_folder_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_post_upload ADD CONSTRAINT FK_8E84CBEF63C2DD4F FOREIGN KEY (fk_user_folder_id) REFERENCES file_explorer (id)');
        $this->addSql('CREATE INDEX IDX_8E84CBEF63C2DD4F ON user_post_upload (fk_user_folder_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_post_upload DROP FOREIGN KEY FK_8E84CBEF63C2DD4F');
        $this->addSql('DROP INDEX IDX_8E84CBEF63C2DD4F ON user_post_upload');
        $this->addSql('ALTER TABLE user_post_upload DROP fk_user_folder_id');
    }
}
