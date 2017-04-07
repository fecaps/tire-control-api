<?php
declare(strict_types=1);

namespace Api\Model\Tire;

use Api\Validator\Tire\Brand as BrandValidator;
use Api\Repository\Tire\Brand as BrandRepository;
use Api\Exception\ValidatorException;

class Brand
{
    private $validator;
    private $repository;
    
    public function __construct(BrandValidator $validator, BrandRepository $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function create(array $brandData): array
    {
        $this->validator->validate($brandData);

        $brand = $brandData['name'];

        $existsName = $this->repository->findByName($brand);

        if ($existsName) {
            $exception = new ValidatorException('This brand name already exists.');
            throw $exception;
        }

        return $this->repository->create($brandData);
    }
}
