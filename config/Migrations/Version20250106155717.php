<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250103155717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creates `product` table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            CREATE TABLE `product` (
                id CHAR(36) NOT NULL PRIMARY KEY,
                sku VARCHAR(50) NOT NULL,
                name VARCHAR(100) NOT NULL,
                category VARCHAR(100) NOT NULL,
                price INTEGER DEFAULT NULL,
                UNIQUE U_product_sku (sku)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE `product`');
    }
}
