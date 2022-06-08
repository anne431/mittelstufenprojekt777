<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\ExamService;
use App\Utility\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/exam", name="exam_")
 */
class ExamController extends AbstractController
{
    public function __construct(
        private ExamService $exam,
    )
    {
    }

    /**
     * @Route("/{taskPosition}", name="index")
     */
    public function exam(int $taskPosition = 0): Response
    {
        /** @var \App\Entity\User|UserInterface $user */
        $user = $this->getUser();
        $warning = null;

        if ($taskPosition < 0) {
            $taskPosition = 0;
            $warning = 'bound_too_low';
        } elseif ($taskPosition > Utility::AMOUNT_EXAM_QUESTIONS - 1) {
            $taskPosition = Utility::AMOUNT_EXAM_QUESTIONS - 1;
            $warning = 'bound_too_high';
        }

        if ($this->exam->getQuestion($taskPosition, $user) === null) {
            $this->createExam($user);
        }

        return $this->render('exam/index.html.twig', [
            'question' => $this->exam->getQuestion($taskPosition, $user),
            'position' => $taskPosition,
            'warning' => $warning,
        ]);
    }

    private function createExam(User|UserInterface $user): void
    {
        $this->exam->create($user);
    }
}
