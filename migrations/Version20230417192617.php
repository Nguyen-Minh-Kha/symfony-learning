<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230417192617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD book_order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33194607B61 FOREIGN KEY (book_order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A33194607B61 ON book (book_order_id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398BCB5C6F5');
        $this->addSql('DROP INDEX UNIQ_F5299398BCB5C6F5 ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE carts_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE user_id carts_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398BCB5C6F5 FOREIGN KEY (carts_id) REFERENCES cart (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5299398BCB5C6F5 ON `order` (carts_id)');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33194607B61');
        $this->addSql('DROP INDEX IDX_CBE5A33194607B61 ON book');
        $this->addSql('ALTER TABLE book DROP book_order_id');
    }
}
