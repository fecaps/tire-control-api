<?php
declare(strict_types=1);

namespace Api\Model\Vehicle;

use Api\Validator\Vehicle\Category as CategoryValidator;
use Api\Repository\Vehicle\Category as CategoryRepository;
use Api\Exception\ValidatorException;

/**
 * @Entity @Table(name="vehicle_category")
 **/
class Category
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @Column(type="string", length=100, unique=true, nullable=false)
     */
    private $name;

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
