<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210125213350 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sold_games (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, price NUMERIC(10, 2) NOT NULL, status VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_414AA3944584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sold_games ADD CONSTRAINT FK_414AA3944584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('DROP TABLE basket_product');
        $this->addSql('ALTER TABLE basket_lanes ADD quantity INT NOT NULL, ADD price NUMERIC(10, 2) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE basket_product (basket_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_17ED14B44584665A (product_id), INDEX IDX_17ED14B41BE1FB52 (basket_id), PRIMARY KEY(basket_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE basket_product ADD CONSTRAINT FK_17ED14B41BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE basket_product ADD CONSTRAINT FK_17ED14B44584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE sold_games');
        $this->addSql('ALTER TABLE basket_lanes DROP quantity, DROP price');
    }
}
