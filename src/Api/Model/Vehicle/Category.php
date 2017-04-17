<?php
declare(strict_types=1);

namespace Api\Model\Vehicle;

use Api\Validator\Vehicle\Category as CategoryValidator;
use Api\Repository\Vehicle\Category as CategoryRepository;
use Api\Exception\ValidatorException;

class Category
{
    private $validator;
    private $repository;
    
    public function __construct(CategoryValidator $validator, CategoryRepository $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function create(array $categoryData): array
    {
        $this->validator->validate($categoryData);

        $category = $categoryData['name'];

        $existsName = $this->repository->findByName($category);

        if ($existsName) {
            $exception = new ValidatorException('This vehicle category name already exists.');
            throw $exception;
        }

        return $this->repository->create($categoryData);
    }

    public function list(): array
    {
        return $this->repository->list();
    }
}
