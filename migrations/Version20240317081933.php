<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240317081933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz (id UUID NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN quiz.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE quiz_answer (id UUID NOT NULL, question_id UUID DEFAULT NULL, text VARCHAR(255) NOT NULL, is_correct BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3799BA7C1E27F6BF ON quiz_answer (question_id)');
        $this->addSql('COMMENT ON COLUMN quiz_answer.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN quiz_answer.question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE quiz_question (id UUID NOT NULL, quiz_id UUID DEFAULT NULL, text VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6033B00B853CD175 ON quiz_question (quiz_id)');
        $this->addSql('COMMENT ON COLUMN quiz_question.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN quiz_question.quiz_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE quiz_result (id UUID NOT NULL, quiz_id UUID NOT NULL, quiz_name VARCHAR(255) NOT NULL, start_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN quiz_result.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN quiz_result.quiz_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN quiz_result.start_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN quiz_result.end_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE quiz_result_question_result (id UUID NOT NULL, quiz_result_id UUID DEFAULT NULL, question_id UUID NOT NULL, question_text VARCHAR(255) NOT NULL, is_correct BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_20FA47631C7C7A5 ON quiz_result_question_result (quiz_result_id)');
        $this->addSql('COMMENT ON COLUMN quiz_result_question_result.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN quiz_result_question_result.quiz_result_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN quiz_result_question_result.question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE quiz_answer ADD CONSTRAINT FK_3799BA7C1E27F6BF FOREIGN KEY (question_id) REFERENCES quiz_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quiz_question ADD CONSTRAINT FK_6033B00B853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quiz_result_question_result ADD CONSTRAINT FK_20FA47631C7C7A5 FOREIGN KEY (quiz_result_id) REFERENCES quiz_result (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE quiz_answer DROP CONSTRAINT FK_3799BA7C1E27F6BF');
        $this->addSql('ALTER TABLE quiz_question DROP CONSTRAINT FK_6033B00B853CD175');
        $this->addSql('ALTER TABLE quiz_result_question_result DROP CONSTRAINT FK_20FA47631C7C7A5');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE quiz_answer');
        $this->addSql('DROP TABLE quiz_question');
        $this->addSql('DROP TABLE quiz_result');
        $this->addSql('DROP TABLE quiz_result_question_result');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
