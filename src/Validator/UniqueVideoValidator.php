<?php

namespace App\Validator;

use App\Repository\VideoRepository;
use App\Service\VideoIdExtractor;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueVideoValidator extends ConstraintValidator
{
    private $videoRepository;
    private $idExtractor;

    public function __construct(VideoRepository $videoRepository, VideoIdExtractor $idExtractor)
    {
        $this->videoRepository = $videoRepository;
        $this->idExtractor = $idExtractor;
    }

    public function validate($value, Constraint $constraint)
    {

        $id = $this->idExtractor->urlToId($value);

        if (!$id)
        {
            $this->context->buildViolation($constraint->invalidUrl)
                ->addViolation();
        }

        $existingVideo = $this->videoRepository->findOneBy([
           'identif' => $id
        ]);

        if (!$existingVideo)
        {
            return;
        }

            $this->context->buildViolation($constraint->message)
                ->addViolation();
    }
}
