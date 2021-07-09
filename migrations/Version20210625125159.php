<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210625125159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces ADD introduction VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8805AB2F');
        $this->addSql('ALTER TABLE comment CHANGE annonce_id annonce_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonces (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces DROP introduction');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8805AB2F');
        $this->addSql('ALTER TABLE comment CHANGE annonce_id annonce_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonces (id)');
    }
}
