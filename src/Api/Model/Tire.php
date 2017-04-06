<?php
declare(strict_types=1);

namespace Api\Model;

use Api\Validator\Tire as TireValidator;
use Api\Repository\Tire as TireRepository;

class Tire
{
    private $validator;
    private $repository;
    
    public function __construct(TireValidator $validator, TireRepository $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function create(array $tireData): array
    {
        $this->validator->validate($tireData);

        return $this->repository->create($tireData);
    }
}
