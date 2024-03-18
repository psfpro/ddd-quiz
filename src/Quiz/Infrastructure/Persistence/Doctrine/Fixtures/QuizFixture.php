<?php

declare(strict_types=1);

namespace App\Quiz\Infrastructure\Persistence\Doctrine\Fixtures;

use App\Quiz\Domain\Quiz\Quiz;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

final class QuizFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $quiz = new Quiz(
            id: Uuid::v7(),
            name: 'The Multifaceted Logic Quiz',
            description: <<<'EOF'
What are fuzzy logic questions?

"2 + 2 = "

1. 4
2. 3 + 1
3. 10

The correct answers here are 1 OR 2 OR (1 AND 2). Any other combination (e.g., 1 AND 3) will not be considered correct, even though it contains the correct answer.
EOF
            ,
        );
        $questionId = Uuid::v7();
        $quiz->addQuestion($questionId, '1 + 1 =');
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '3', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '2', true);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '0', false);

        $questionId = Uuid::v7();
        $quiz->addQuestion($questionId, '2 + 2 =');
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '4', true);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '3 + 1', true);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '10', false);

        $questionId = Uuid::v7();
        $quiz->addQuestion($questionId, '3 + 3 =');
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '1 + 5', true);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '1', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '6', true);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '2 + 4', true);

        $questionId = Uuid::v7();
        $quiz->addQuestion($questionId, '4 + 4 =');
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '8', true);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '4', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '0', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '0 + 8', true);

        $questionId = Uuid::v7();
        $quiz->addQuestion($questionId, '5 + 5 =');
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '6', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '18', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '10', true);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '9', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '0', false);

        $questionId = Uuid::v7();
        $quiz->addQuestion($questionId, '6 + 6 =');
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '3', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '9', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '0', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '12', true);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '5 + 7', true);

        $questionId = Uuid::v7();
        $quiz->addQuestion($questionId, '7 + 7 =');
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '5', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '14', true);

        $questionId = Uuid::v7();
        $quiz->addQuestion($questionId, '8 + 8 =');
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '16', true);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '12', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '9', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '5', false);

        $questionId = Uuid::v7();
        $quiz->addQuestion($questionId, '9 + 9 =');
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '18', true);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '9', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '17 + 1', true);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '2 + 16', true);

        $questionId = Uuid::v7();
        $quiz->addQuestion($questionId, '10 + 10 =');
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '0', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '2', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '8', false);
        $quiz->addQuestionAnswer($questionId, Uuid::v7(), '20', true);

        $manager->persist($quiz);
        $manager->flush();
    }
}