<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200209100317 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE traduction (id INT AUTO_INCREMENT NOT NULL, spelling VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE traduction_word (traduction_id INT NOT NULL, word_id INT NOT NULL, INDEX IDX_687B57D67E0955EF (traduction_id), INDEX IDX_687B57D6E357438D (word_id), PRIMARY KEY(traduction_id, word_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE traduction_word ADD CONSTRAINT FK_687B57D67E0955EF FOREIGN KEY (traduction_id) REFERENCES traduction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_word ADD CONSTRAINT FK_687B57D6E357438D FOREIGN KEY (word_id) REFERENCES word (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE traduction_word DROP FOREIGN KEY FK_687B57D67E0955EF');
        $this->addSql('DROP TABLE traduction');
        $this->addSql('DROP TABLE traduction_word');
    }
}
