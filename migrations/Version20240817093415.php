<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240817093415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE cubiculo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE horario_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reserva_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reserva_estado_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cubiculo (id INT NOT NULL, capacidad INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE horario (id INT NOT NULL, hora TIME(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reserva (id INT NOT NULL, estado_id INT NOT NULL, usuario_id INT NOT NULL, cubiculo_id INT NOT NULL, horario_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_188D2E3B9F5A440B ON reserva (estado_id)');
        $this->addSql('CREATE INDEX IDX_188D2E3BDB38439E ON reserva (usuario_id)');
        $this->addSql('CREATE INDEX IDX_188D2E3B48D6B68A ON reserva (cubiculo_id)');
        $this->addSql('CREATE INDEX IDX_188D2E3B4959F1BA ON reserva (horario_id)');
        $this->addSql('CREATE TABLE reserva_estado (id INT NOT NULL, estado VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B9F5A440B FOREIGN KEY (estado_id) REFERENCES reserva_estado (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B48D6B68A FOREIGN KEY (cubiculo_id) REFERENCES cubiculo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B4959F1BA FOREIGN KEY (horario_id) REFERENCES horario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE cubiculo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE horario_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reserva_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reserva_estado_id_seq CASCADE');
        $this->addSql('ALTER TABLE reserva DROP CONSTRAINT FK_188D2E3B9F5A440B');
        $this->addSql('ALTER TABLE reserva DROP CONSTRAINT FK_188D2E3BDB38439E');
        $this->addSql('ALTER TABLE reserva DROP CONSTRAINT FK_188D2E3B48D6B68A');
        $this->addSql('ALTER TABLE reserva DROP CONSTRAINT FK_188D2E3B4959F1BA');
        $this->addSql('DROP TABLE cubiculo');
        $this->addSql('DROP TABLE horario');
        $this->addSql('DROP TABLE reserva');
        $this->addSql('DROP TABLE reserva_estado');
    }
}
