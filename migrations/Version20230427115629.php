<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230427115629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52BE7470F2C');
        $this->addSql('DROP INDEX IDX_8B27C52BE7470F2C ON devis');
        $this->addSql('ALTER TABLE devis DROP haie_id');
        $this->addSql('ALTER TABLE haie CHANGE code code VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis ADD haie_id INT NOT NULL');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52BE7470F2C FOREIGN KEY (haie_id) REFERENCES haie (code)');
        $this->addSql('CREATE INDEX IDX_8B27C52BE7470F2C ON devis (haie_id)');
        $this->addSql('ALTER TABLE haie CHANGE code code INT NOT NULL');
    }
}
