<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180128165057 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE eventos (id INT AUTO_INCREMENT NOT NULL, id_creador_id INT DEFAULT NULL, categoria_id INT DEFAULT NULL, provincia_id INT DEFAULT NULL, nombre VARCHAR(100) NOT NULL, descripcion VARCHAR(100) NOT NULL, poster VARCHAR(100) NOT NULL, enlace_externo VARCHAR(100) DEFAULT NULL, direccion VARCHAR(100) NOT NULL, fecha_venta_inicio DATE NOT NULL, fecha_venta_final DATE NOT NULL, fecha_evento DATE NOT NULL, num_entradas_tot INT NOT NULL, num_entradas_res INT NOT NULL, precio NUMERIC(9, 2) NOT NULL, INDEX IDX_6B23BD8FC77E8CEA (id_creador_id), INDEX IDX_6B23BD8F3397707A (categoria_id), INDEX IDX_6B23BD8F4E7121AF (provincia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuarios (id INT AUTO_INCREMENT NOT NULL, provincia_id INT DEFAULT NULL, nombre VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, passwd VARCHAR(100) NOT NULL, avatar VARCHAR(100) NOT NULL, fecha_alta DATE NOT NULL, role VARCHAR(100) NOT NULL, salt VARCHAR(100) NOT NULL, lang VARCHAR(100) NOT NULL, INDEX IDX_EF687F24E7121AF (provincia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provincias (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorias (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facturas (id INT AUTO_INCREMENT NOT NULL, usuario_id_id INT DEFAULT NULL, evento_id_id INT DEFAULT NULL, fecha_compra DATE NOT NULL, cantidad INT NOT NULL, barcode VARCHAR(100) NOT NULL, ip VARCHAR(100) NOT NULL, INDEX IDX_622B9C0F629AF449 (usuario_id_id), INDEX IDX_622B9C0F6F86A0CB (evento_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mensajes (id INT AUTO_INCREMENT NOT NULL, emisor_id INT DEFAULT NULL, receptor_id INT DEFAULT NULL, fecha DATE NOT NULL, mensaje TEXT NOT NULL, INDEX IDX_6C929C806BDF87DF (emisor_id), INDEX IDX_6C929C80386D8D01 (receptor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eventos ADD CONSTRAINT FK_6B23BD8FC77E8CEA FOREIGN KEY (id_creador_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE eventos ADD CONSTRAINT FK_6B23BD8F3397707A FOREIGN KEY (categoria_id) REFERENCES categorias (id)');
        $this->addSql('ALTER TABLE eventos ADD CONSTRAINT FK_6B23BD8F4E7121AF FOREIGN KEY (provincia_id) REFERENCES provincias (id)');
        $this->addSql('ALTER TABLE usuarios ADD CONSTRAINT FK_EF687F24E7121AF FOREIGN KEY (provincia_id) REFERENCES provincias (id)');
        $this->addSql('ALTER TABLE facturas ADD CONSTRAINT FK_622B9C0F629AF449 FOREIGN KEY (usuario_id_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE facturas ADD CONSTRAINT FK_622B9C0F6F86A0CB FOREIGN KEY (evento_id_id) REFERENCES eventos (id)');
        $this->addSql('ALTER TABLE mensajes ADD CONSTRAINT FK_6C929C806BDF87DF FOREIGN KEY (emisor_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE mensajes ADD CONSTRAINT FK_6C929C80386D8D01 FOREIGN KEY (receptor_id) REFERENCES usuarios (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE facturas DROP FOREIGN KEY FK_622B9C0F6F86A0CB');
        $this->addSql('ALTER TABLE eventos DROP FOREIGN KEY FK_6B23BD8FC77E8CEA');
        $this->addSql('ALTER TABLE facturas DROP FOREIGN KEY FK_622B9C0F629AF449');
        $this->addSql('ALTER TABLE mensajes DROP FOREIGN KEY FK_6C929C806BDF87DF');
        $this->addSql('ALTER TABLE mensajes DROP FOREIGN KEY FK_6C929C80386D8D01');
        $this->addSql('ALTER TABLE eventos DROP FOREIGN KEY FK_6B23BD8F4E7121AF');
        $this->addSql('ALTER TABLE usuarios DROP FOREIGN KEY FK_EF687F24E7121AF');
        $this->addSql('ALTER TABLE eventos DROP FOREIGN KEY FK_6B23BD8F3397707A');
        $this->addSql('DROP TABLE eventos');
        $this->addSql('DROP TABLE usuarios');
        $this->addSql('DROP TABLE provincias');
        $this->addSql('DROP TABLE categorias');
        $this->addSql('DROP TABLE facturas');
        $this->addSql('DROP TABLE mensajes');
    }
}
