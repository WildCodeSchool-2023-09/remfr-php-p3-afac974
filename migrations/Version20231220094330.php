<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220094330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, photo_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1599687E7927C74 (email), UNIQUE INDEX UNIQ_1599687A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artwork (id INT AUTO_INCREMENT NOT NULL, artist_id INT DEFAULT NULL, description LONGTEXT NOT NULL, title VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, height INT NOT NULL, width INT NOT NULL, is_unique TINYINT(1) NOT NULL, is_signed TINYINT(1) NOT NULL, INDEX IDX_881FC576B7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, artwork_id INT DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_9474526C67B3B43D (users_id), INDEX IDX_9474526CDB8FFA4 (artwork_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, artwork_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_68C58ED9DB8FFA4 (artwork_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite_users (favorite_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_A20B8ECDAA17481D (favorite_id), INDEX IDX_A20B8ECD67B3B43D (users_id), PRIMARY KEY(favorite_id, users_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, artist_id INT DEFAULT NULL, newsletter_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, photo_news VARCHAR(255) NOT NULL, INDEX IDX_1DD39950B7970CF8 (artist_id), INDEX IDX_1DD3995022DB1917 (newsletter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postcard (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, artwork_id INT DEFAULT NULL, INDEX IDX_2380C5A67B3B43D (users_id), UNIQUE INDEX UNIQ_2380C5ADB8FFA4 (artwork_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technic (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_DFBF61F8C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, artwork_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8CDE5729DB8FFA4 (artwork_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT FK_1599687A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC576B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CDB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9DB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id)');
        $this->addSql('ALTER TABLE favorite_users ADD CONSTRAINT FK_A20B8ECDAA17481D FOREIGN KEY (favorite_id) REFERENCES favorite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_users ADD CONSTRAINT FK_A20B8ECD67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD3995022DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id)');
        $this->addSql('ALTER TABLE postcard ADD CONSTRAINT FK_2380C5A67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE postcard ADD CONSTRAINT FK_2380C5ADB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id)');
        $this->addSql('ALTER TABLE technic ADD CONSTRAINT FK_DFBF61F8C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE type ADD CONSTRAINT FK_8CDE5729DB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist DROP FOREIGN KEY FK_1599687A76ED395');
        $this->addSql('ALTER TABLE artwork DROP FOREIGN KEY FK_881FC576B7970CF8');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C67B3B43D');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CDB8FFA4');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9DB8FFA4');
        $this->addSql('ALTER TABLE favorite_users DROP FOREIGN KEY FK_A20B8ECDAA17481D');
        $this->addSql('ALTER TABLE favorite_users DROP FOREIGN KEY FK_A20B8ECD67B3B43D');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD39950B7970CF8');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD3995022DB1917');
        $this->addSql('ALTER TABLE postcard DROP FOREIGN KEY FK_2380C5A67B3B43D');
        $this->addSql('ALTER TABLE postcard DROP FOREIGN KEY FK_2380C5ADB8FFA4');
        $this->addSql('ALTER TABLE technic DROP FOREIGN KEY FK_DFBF61F8C54C8C93');
        $this->addSql('ALTER TABLE type DROP FOREIGN KEY FK_8CDE5729DB8FFA4');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE artwork');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE favorite_users');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE postcard');
        $this->addSql('DROP TABLE technic');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
