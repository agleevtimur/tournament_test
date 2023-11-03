<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231101201534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE tournament_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE team_tournament (team_id INT NOT NULL, tournament_id INT NOT NULL, PRIMARY KEY(team_id, tournament_id))');
        $this->addSql('CREATE INDEX IDX_8386CA1C296CD8AE ON team_tournament (team_id)');
        $this->addSql('CREATE INDEX IDX_8386CA1C33D1A3E7 ON team_tournament (tournament_id)');
        $this->addSql('CREATE TABLE tournament (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE team_tournament ADD CONSTRAINT FK_8386CA1C296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_tournament ADD CONSTRAINT FK_8386CA1C33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C4E0A61F5E237E06 ON team (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE tournament_id_seq CASCADE');
        $this->addSql('ALTER TABLE team_tournament DROP CONSTRAINT FK_8386CA1C296CD8AE');
        $this->addSql('ALTER TABLE team_tournament DROP CONSTRAINT FK_8386CA1C33D1A3E7');
        $this->addSql('DROP TABLE team_tournament');
        $this->addSql('DROP TABLE tournament');
        $this->addSql('DROP INDEX UNIQ_C4E0A61F5E237E06');
    }
}
