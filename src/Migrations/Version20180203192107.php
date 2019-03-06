<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180203192107 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE eventos DROP FOREIGN KEY FK_6B23BD8FC77E8CEA');
        $this->addSql('DROP INDEX IDX_6B23BD8FC77E8CEA ON eventos');
        $this->addSql('ALTER TABLE eventos CHANGE id_creador_id autor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE eventos ADD CONSTRAINT FK_6B23BD8F14D45BBE FOREIGN KEY (autor_id) REFERENCES usuarios (id)');
        $this->addSql('CREATE INDEX IDX_6B23BD8F14D45BBE ON eventos (autor_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE eventos DROP FOREIGN KEY FK_6B23BD8F14D45BBE');
        $this->addSql('DROP INDEX IDX_6B23BD8F14D45BBE ON eventos');
        $this->addSql('ALTER TABLE eventos CHANGE autor_id id_creador_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE eventos ADD CONSTRAINT FK_6B23BD8FC77E8CEA FOREIGN KEY (id_creador_id) REFERENCES usuarios (id)');
        $this->addSql('CREATE INDEX IDX_6B23BD8FC77E8CEA ON eventos (id_creador_id)');
    }
}
