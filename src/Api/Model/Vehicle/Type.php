<?php
declare(strict_types=1);

namespace Api\Model\Vehicle;

use Api\Validator\Vehicle\Type as TypeValidator;
use Api\Repository\Vehicle\Type as TypeRepository;
use Api\Exception\ValidatorException;

class Type
{
    private $validator;
    private $repository;
    
    public function __construct(TypeValidator $validator, TypeRepository $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function create(array $typeData): array
    {
        $this->validator->validate($typeData);

        $type = $typeData['name'];

        $existsName = $this->repository->findByName($type);

        if ($existsName) {
            $exception = new ValidatorException('This vehicle type name already exists.');
            throw $exception;
        }

        return $this->repository->create($typeData);
    }

    public function list(): array
    {
        return $this->repository->list();
    }
}
