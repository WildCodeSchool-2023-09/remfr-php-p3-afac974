<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219152643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, description LONGTEXT NOT NULL, photo_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_15996879D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artwork (id INT AUTO_INCREMENT NOT NULL, artist_id_id INT DEFAULT NULL, type_id_id INT DEFAULT NULL, description LONGTEXT NOT NULL, title VARCHAR(255) NOT NULL, height INT NOT NULL, width INT NOT NULL, reference VARCHAR(255) NOT NULL, is_unique TINYINT(1) NOT NULL, is_signed TINYINT(1) NOT NULL, INDEX IDX_881FC5761F48AE04 (artist_id_id), INDEX IDX_881FC576714819A0 (type_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, artwork_id_id INT DEFAULT NULL, comments LONGTEXT NOT NULL, INDEX IDX_9474526C9D86650F (user_id_id), INDEX IDX_9474526CEEAEF64D (artwork_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, artwork_id_id INT DEFAULT NULL, INDEX IDX_68C58ED99D86650F (user_id_id), INDEX IDX_68C58ED9EEAEF64D (artwork_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, artist_id_id INT DEFAULT NULL, newsletter_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, desciption LONGTEXT NOT NULL, news_image_name VARCHAR(255) NOT NULL, INDEX IDX_1DD399501F48AE04 (artist_id_id), INDEX IDX_1DD3995022DB1917 (newsletter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postcard (id INT AUTO_INCREMENT NOT NULL, artwork_id_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_2380C5AEEAEF64D (artwork_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postcard_user (postcard_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F08D182A83DD99C6 (postcard_id), INDEX IDX_F08D182AA76ED395 (user_id), PRIMARY KEY(postcard_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technic (id INT AUTO_INCREMENT NOT NULL, type_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_DFBF61F8714819A0 (type_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT FK_15996879D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC5761F48AE04 FOREIGN KEY (artist_id_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC576714819A0 FOREIGN KEY (type_id_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CEEAEF64D FOREIGN KEY (artwork_id_id) REFERENCES artwork (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED99D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9EEAEF64D FOREIGN KEY (artwork_id_id) REFERENCES artwork (id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399501F48AE04 FOREIGN KEY (artist_id_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD3995022DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id)');
        $this->addSql('ALTER TABLE postcard ADD CONSTRAINT FK_2380C5AEEAEF64D FOREIGN KEY (artwork_id_id) REFERENCES artwork (id)');
        $this->addSql('ALTER TABLE postcard_user ADD CONSTRAINT FK_F08D182A83DD99C6 FOREIGN KEY (postcard_id) REFERENCES postcard (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postcard_user ADD CONSTRAINT FK_F08D182AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technic ADD CONSTRAINT FK_DFBF61F8714819A0 FOREIGN KEY (type_id_id) REFERENCES type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist DROP FOREIGN KEY FK_15996879D86650F');
        $this->addSql('ALTER TABLE artwork DROP FOREIGN KEY FK_881FC5761F48AE04');
        $this->addSql('ALTER TABLE artwork DROP FOREIGN KEY FK_881FC576714819A0');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9D86650F');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CEEAEF64D');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED99D86650F');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9EEAEF64D');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD399501F48AE04');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD3995022DB1917');
        $this->addSql('ALTER TABLE postcard DROP FOREIGN KEY FK_2380C5AEEAEF64D');
        $this->addSql('ALTER TABLE postcard_user DROP FOREIGN KEY FK_F08D182A83DD99C6');
        $this->addSql('ALTER TABLE postcard_user DROP FOREIGN KEY FK_F08D182AA76ED395');
        $this->addSql('ALTER TABLE technic DROP FOREIGN KEY FK_DFBF61F8714819A0');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE artwork');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE postcard');
        $this->addSql('DROP TABLE postcard_user');
        $this->addSql('DROP TABLE technic');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
