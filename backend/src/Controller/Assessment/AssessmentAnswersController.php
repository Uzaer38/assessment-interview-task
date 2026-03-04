<?php

declare(strict_types=1);

namespace App\Controller\Assessment;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\AssessmentService;

class AssessmentAnswersController extends AbstractController
{
    private AssessmentService $assessmentService;

    public function __construct(AssessmentService $assessmentService)
    {
        $this->assessmentService = $assessmentService;
    }

    /**
     * @Route("/api/assessment/answers", methods={"POST"})
     */
    public function submitAnswer(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $result = $this->assessmentService->submitAnswer($data);

        return $this->json($result, Response::HTTP_CREATED);
    }
}