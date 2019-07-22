<?php

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ForgotPasswordValidator extends ConstraintValidator
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        $checkIfEmailExist = $this->userRepository->findByMail($value);

        if ($checkIfEmailExist)
        {
            return;
        }

        $this->context->buildViolation($constraint->mailNotFound)
            ->addViolation();
    }
}
