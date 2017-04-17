<?php
declare(strict_types=1);

namespace Api\Model\Vehicle;

use Api\Validator\Vehicle\Model as ModelValidator;
use Api\Repository\Vehicle\Model as ModelRepository;
use Api\Exception\ValidatorException;

class Model
{
    private $validator;
    private $repository;
    
    public function __construct(ModelValidator $validator, ModelRepository $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function create(array $modelData): array
    {
        $this->validator->validate($modelData);

        $model = $modelData['name'];

        $existsName = $this->repository->findByName($model);

        if ($existsName) {
            $exception = new ValidatorException('This vehicle model name already exists.');
            throw $exception;
        }

        return $this->repository->create($modelData);
    }

    public function list(): array
    {
        return $this->repository->list();
    }
}
