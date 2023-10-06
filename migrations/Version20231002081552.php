<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231002081552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT IDENTITY NOT NULL, name NVARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE model (id INT IDENTITY NOT NULL, brand_id INT NOT NULL, name NVARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_D79572D944F5D008 ON model (brand_id)');
        $this->addSql('CREATE TABLE [option] (id INT IDENTITY NOT NULL, name NVARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE option_vehicle (option_id INT NOT NULL, vehicle_id INT NOT NULL, PRIMARY KEY (option_id, vehicle_id))');
        $this->addSql('CREATE INDEX IDX_374F3F3A7C41D6F ON option_vehicle (option_id)');
        $this->addSql('CREATE INDEX IDX_374F3F3545317D1 ON option_vehicle (vehicle_id)');
        $this->addSql('CREATE TABLE reservation (id INT IDENTITY NOT NULL, state_id INT NOT NULL, vehicle_id INT NOT NULL, userr_id INT NOT NULL, reference NVARCHAR(255) NOT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, number_rental_day INT, total_cost INT, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_42C849555D83CC1 ON reservation (state_id)');
        $this->addSql('CREATE INDEX IDX_42C84955545317D1 ON reservation (vehicle_id)');
        $this->addSql('CREATE INDEX IDX_42C84955DF0FD358 ON reservation (userr_id)');
        $this->addSql('CREATE TABLE state (id INT IDENTITY NOT NULL, status NVARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE type (id INT IDENTITY NOT NULL, name NVARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE [user] (id INT IDENTITY NOT NULL, email NVARCHAR(180) NOT NULL, roles VARCHAR(MAX) NOT NULL, password NVARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON [user] (email) WHERE email IS NOT NULL');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:json)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'user\', N\'COLUMN\', roles');
        $this->addSql('CREATE TABLE vehicle (id INT IDENTITY NOT NULL, model_id INT NOT NULL, type_id INT NOT NULL, capacity INT NOT NULL, price INT NOT NULL, number_plate NVARCHAR(255) NOT NULL, year_of_car INT NOT NULL, number_kilometers INT NOT NULL, img_path NVARCHAR(255), PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_1B80E4867975B7E7 ON vehicle (model_id)');
        $this->addSql('CREATE INDEX IDX_1B80E486C54C8C93 ON vehicle (type_id)');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE option_vehicle ADD CONSTRAINT FK_374F3F3A7C41D6F FOREIGN KEY (option_id) REFERENCES [option] (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE option_vehicle ADD CONSTRAINT FK_374F3F3545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849555D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955DF0FD358 FOREIGN KEY (userr_id) REFERENCES [user] (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4867975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model DROP CONSTRAINT FK_D79572D944F5D008');
        $this->addSql('ALTER TABLE option_vehicle DROP CONSTRAINT FK_374F3F3A7C41D6F');
        $this->addSql('ALTER TABLE option_vehicle DROP CONSTRAINT FK_374F3F3545317D1');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C849555D83CC1');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C84955545317D1');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C84955DF0FD358');
        $this->addSql('ALTER TABLE vehicle DROP CONSTRAINT FK_1B80E4867975B7E7');
        $this->addSql('ALTER TABLE vehicle DROP CONSTRAINT FK_1B80E486C54C8C93');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE [option]');
        $this->addSql('DROP TABLE option_vehicle');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE [user]');
        $this->addSql('DROP TABLE vehicle');
    }
}
