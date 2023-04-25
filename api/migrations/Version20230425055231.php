<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230425055231 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, placed_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_6117D13B7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_item (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, cart_id INT NOT NULL, qty INT NOT NULL, price NUMERIC(10, 2) NOT NULL, INDEX IDX_6FA8ED7D4584665A (product_id), INDEX IDX_6FA8ED7D1AD5CDBF (cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE purchase_item ADD CONSTRAINT FK_6FA8ED7D4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE purchase_item ADD CONSTRAINT FK_6FA8ED7D1AD5CDBF FOREIGN KEY (cart_id) REFERENCES purchase (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B7E3C61F9');
        $this->addSql('ALTER TABLE purchase_item DROP FOREIGN KEY FK_6FA8ED7D4584665A');
        $this->addSql('ALTER TABLE purchase_item DROP FOREIGN KEY FK_6FA8ED7D1AD5CDBF');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE purchase_item');
    }
}
