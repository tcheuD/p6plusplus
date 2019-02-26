<?php

namespace App\Validator;

use App\Repository\VideoRepository;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueVideoValidator extends ConstraintValidator
{
    private $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint App/Validator\UniqueVideo */

        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $value, $match);

        $existingVideo = $this->videoRepository->findOneBy([
           'identif' => $match[1]
        ]);

        if (!$existingVideo) {
            return;
        }

            $this->context->buildViolation($constraint->message)
                ->addViolation();
    }
}
