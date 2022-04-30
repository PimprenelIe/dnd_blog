<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427170943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD content LONGTEXT NOT NULL, ADD keyword_seo VARCHAR(30) DEFAULT NULL, ADD help_seo INT DEFAULT NULL, ADD meta_title VARCHAR(70) DEFAULT NULL, ADD meta_description VARCHAR(255) DEFAULT NULL, ADD visit INT DEFAULT NULL');
        $this->addSql('ALTER TABLE keyword ADD content LONGTEXT NOT NULL, ADD keyword_seo VARCHAR(30) DEFAULT NULL, ADD help_seo INT DEFAULT NULL, ADD meta_title VARCHAR(70) DEFAULT NULL, ADD meta_description VARCHAR(255) DEFAULT NULL, ADD visit INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP content, DROP keyword_seo, DROP help_seo, DROP meta_title, DROP meta_description, DROP visit');
        $this->addSql('ALTER TABLE keyword DROP content, DROP keyword_seo, DROP help_seo, DROP meta_title, DROP meta_description, DROP visit');
    }
}
