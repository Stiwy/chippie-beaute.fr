<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220318131446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_category ADD position_column INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE label label VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sub_category DROP position_column, CHANGE label label VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE position position VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `user` CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname lastname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE firstname firstname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address_complement address_complement VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
