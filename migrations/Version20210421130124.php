<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210421130124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog_product ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE catalog_product ADD CONSTRAINT FK_DCF8F98112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_DCF8F98112469DE2 ON catalog_product (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog_product DROP FOREIGN KEY FK_DCF8F98112469DE2');
        $this->addSql('DROP INDEX IDX_DCF8F98112469DE2 ON catalog_product');
        $this->addSql('ALTER TABLE catalog_product DROP category_id');
    }
}
