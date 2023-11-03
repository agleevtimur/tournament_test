<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231101231019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tournament_team (tournament_id INT NOT NULL, team_id INT NOT NULL, PRIMARY KEY(tournament_id, team_id))');
        $this->addSql('CREATE INDEX IDX_F36D142133D1A3E7 ON tournament_team (tournament_id)');
        $this->addSql('CREATE INDEX IDX_F36D1421296CD8AE ON tournament_team (team_id)');
        $this->addSql('ALTER TABLE tournament_team ADD CONSTRAINT FK_F36D142133D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tournament_team ADD CONSTRAINT FK_F36D1421296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_tournament DROP CONSTRAINT fk_8386ca1c296cd8ae');
        $this->addSql('ALTER TABLE team_tournament DROP CONSTRAINT fk_8386ca1c33d1a3e7');
        $this->addSql('DROP TABLE team_tournament');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE team_tournament (team_id INT NOT NULL, tournament_id INT NOT NULL, PRIMARY KEY(team_id, tournament_id))');
        $this->addSql('CREATE INDEX idx_8386ca1c33d1a3e7 ON team_tournament (tournament_id)');
        $this->addSql('CREATE INDEX idx_8386ca1c296cd8ae ON team_tournament (team_id)');
        $this->addSql('ALTER TABLE team_tournament ADD CONSTRAINT fk_8386ca1c296cd8ae FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_tournament ADD CONSTRAINT fk_8386ca1c33d1a3e7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tournament_team DROP CONSTRAINT FK_F36D142133D1A3E7');
        $this->addSql('ALTER TABLE tournament_team DROP CONSTRAINT FK_F36D1421296CD8AE');
        $this->addSql('DROP TABLE tournament_team');
    }
}
