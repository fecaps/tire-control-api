<?php
declare(strict_types=1);

namespace Api\Model\Vehicle;

use Api\Validator\Vehicle\Model as ModelValidator;
use Api\Repository\Vehicle\Model as ModelRepository;
use Api\Repository\Vehicle\Brand as BrandRepository;
use Api\Exception\ValidatorException;

class Model
{
    private $validator;
    private $repository;
    private $brandRepository;
    
    public function __construct(
        ModelValidator $validator,
        ModelRepository $repository,
        BrandRepository $brandRepository
    ) {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->brandRepository = $brandRepository;
    }

    public function create(array $modelData): array
    {
        $exception = new ValidatorException;

        $this->validator->validate($modelData);

        $brand = $modelData['brand'];
        $model = $modelData['model'];

        $existsBrand = $this->brandRepository->findByName($brand);

        if (!$existsBrand) {
            $exception->addMessage('brand', 'The brand must be registered in the vehicle brand table.');
        }

        $existsModel = $this->repository->findByModel($model);

        if ($existsModel) {
            $exception->addMessage('model', 'This vehicle model already exists.');
        }

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }

        return $this->repository->create($modelData);
    }

    public function list(): array
    {
        return $this->repository->list();
    }
}
