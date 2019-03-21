<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService
{
    /** @var  ValidatorInterface */
    protected $validator;

    /**
     * ValidationService constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param string $ipValue
     * @return ConstraintViolationListInterface
     */
    public function validateIp(string $ipValue): ConstraintViolationListInterface
    {
        $ipConstraint = new Assert\Ip();
        $ipConstraint->version = 'all';

        return $this->validator->validate($ipValue, $ipConstraint);
    }
}