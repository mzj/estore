<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120115181839 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX translations_lookup_idx (locale, object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, foreign_key, field), PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE ext_log_entries (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(8) NOT NULL, logged_at DATETIME NOT NULL, object_id VARCHAR(32) DEFAULT NULL, object_class VARCHAR(255) NOT NULL, version INT NOT NULL, data LONGTEXT DEFAULT NULL COMMENT '(DC2Type:array)', username VARCHAR(255) DEFAULT NULL, INDEX log_class_lookup_idx (object_class), INDEX log_date_lookup_idx (logged_at), INDEX log_user_lookup_idx (username), PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE colour (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, price NUMERIC(10, 2) NOT NULL, active TINYINT(1) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, slug VARCHAR(128) NOT NULL, gender INT NOT NULL, UNIQUE INDEX UNIQ_D34A04AD989D9B62 (slug), PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE category_product (product_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_149244D34584665A (product_id), INDEX IDX_149244D312469DE2 (category_id), PRIMARY KEY(product_id, category_id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, root INT DEFAULT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_64C19C1989D9B62 (slug), INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE garment (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, size INT NOT NULL, quantity INT NOT NULL, INDEX IDX_B881175C4584665A (product_id), PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE garment_colour (garment_id INT NOT NULL, colour_id INT NOT NULL, INDEX IDX_AD2DCCFA9CDB257C (garment_id), INDEX IDX_AD2DCCFA569C9B4C (colour_id), PRIMARY KEY(garment_id, colour_id)) ENGINE = InnoDB");
        $this->addSql("ALTER TABLE category_product ADD CONSTRAINT FK_149244D34584665A FOREIGN KEY (product_id) REFERENCES product(id)");
        $this->addSql("ALTER TABLE category_product ADD CONSTRAINT FK_149244D312469DE2 FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category(id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE garment ADD CONSTRAINT FK_B881175C4584665A FOREIGN KEY (product_id) REFERENCES product(id)");
        $this->addSql("ALTER TABLE garment_colour ADD CONSTRAINT FK_AD2DCCFA9CDB257C FOREIGN KEY (garment_id) REFERENCES garment(id)");
        $this->addSql("ALTER TABLE garment_colour ADD CONSTRAINT FK_AD2DCCFA569C9B4C FOREIGN KEY (colour_id) REFERENCES colour(id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE garment_colour DROP FOREIGN KEY FK_AD2DCCFA569C9B4C");
        $this->addSql("ALTER TABLE category_product DROP FOREIGN KEY FK_149244D34584665A");
        $this->addSql("ALTER TABLE garment DROP FOREIGN KEY FK_B881175C4584665A");
        $this->addSql("ALTER TABLE category_product DROP FOREIGN KEY FK_149244D312469DE2");
        $this->addSql("ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70");
        $this->addSql("ALTER TABLE garment_colour DROP FOREIGN KEY FK_AD2DCCFA9CDB257C");
        $this->addSql("DROP TABLE ext_translations");
        $this->addSql("DROP TABLE ext_log_entries");
        $this->addSql("DROP TABLE colour");
        $this->addSql("DROP TABLE product");
        $this->addSql("DROP TABLE category_product");
        $this->addSql("DROP TABLE category");
        $this->addSql("DROP TABLE garment");
        $this->addSql("DROP TABLE garment_colour");
    }
}
