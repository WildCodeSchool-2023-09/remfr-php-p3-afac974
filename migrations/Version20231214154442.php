<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214154442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, link_users_artist_id INT DEFAULT NULL, description LONGTEXT NOT NULL, immatriculation INT NOT NULL, photo VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_15996873E2B12F7 (link_users_artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artwork (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, height INT NOT NULL, width INT NOT NULL, unique_or_not TINYINT(1) NOT NULL, sign_or_not TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, link_users_comments_id INT DEFAULT NULL, link_artwork_comments_id INT NOT NULL, comment LONGTEXT NOT NULL, INDEX IDX_5F9E962A1EA03D96 (link_users_comments_id), INDEX IDX_5F9E962AB601B77D (link_artwork_comments_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorites (id INT AUTO_INCREMENT NOT NULL, link_artwork_favorites_id INT DEFAULT NULL, INDEX IDX_E46960F5AE67DB02 (link_artwork_favorites_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_card (id INT AUTO_INCREMENT NOT NULL, link_artwork_post_card_id INT DEFAULT NULL, link_users_post_card_id INT DEFAULT NULL, INDEX IDX_DF41FFD85D9E30A5 (link_artwork_post_card_id), INDEX IDX_DF41FFD86AEEAADF (link_users_post_card_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technique_used (id INT AUTO_INCREMENT NOT NULL, link_type_of_work_technique_id INT DEFAULT NULL, technique VARCHAR(255) NOT NULL, INDEX IDX_DF42F21831F71C08 (link_type_of_work_technique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_of_work (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT FK_15996873E2B12F7 FOREIGN KEY (link_users_artist_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A1EA03D96 FOREIGN KEY (link_users_comments_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AB601B77D FOREIGN KEY (link_artwork_comments_id) REFERENCES artwork (id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F5AE67DB02 FOREIGN KEY (link_artwork_favorites_id) REFERENCES artwork (id)');
        $this->addSql('ALTER TABLE post_card ADD CONSTRAINT FK_DF41FFD85D9E30A5 FOREIGN KEY (link_artwork_post_card_id) REFERENCES artwork (id)');
        $this->addSql('ALTER TABLE post_card ADD CONSTRAINT FK_DF41FFD86AEEAADF FOREIGN KEY (link_users_post_card_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE technique_used ADD CONSTRAINT FK_DF42F21831F71C08 FOREIGN KEY (link_type_of_work_technique_id) REFERENCES type_of_work (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist DROP FOREIGN KEY FK_15996873E2B12F7');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A1EA03D96');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AB601B77D');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F5AE67DB02');
        $this->addSql('ALTER TABLE post_card DROP FOREIGN KEY FK_DF41FFD85D9E30A5');
        $this->addSql('ALTER TABLE post_card DROP FOREIGN KEY FK_DF41FFD86AEEAADF');
        $this->addSql('ALTER TABLE technique_used DROP FOREIGN KEY FK_DF42F21831F71C08');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE artwork');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE favorites');
        $this->addSql('DROP TABLE post_card');
        $this->addSql('DROP TABLE technique_used');
        $this->addSql('DROP TABLE type_of_work');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
