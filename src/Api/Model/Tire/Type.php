<?php
declare(strict_types=1);

namespace Api\Model\Tire;

use Api\Validator\Tire\Type as TypeValidator;
use Api\Repository\Tire\Type as TypeRepository;
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
            $exception = new ValidatorException('This type name already exists.');
            throw $exception;
        }

        return $this->repository->create($typeData);
    }

    public function selectAll(): array
    {
        return $this->repository->selectAll();
    }
}
