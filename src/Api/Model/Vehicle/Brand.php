<?php
declare(strict_types=1);

namespace Api\Model\Vehicle;

use Api\Validator\Vehicle\Brand as BrandValidator;
use Api\Repository\Vehicle\Brand as BrandRepository;
use Api\Exception\ValidatorException;

/**
 * @Entity @Table(name="vehicle_brand")
 **/
class Brand
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
            $exception = new ValidatorException('This vehicle brand name already exists.');
            throw $exception;
        }

        return $this->repository->create($brandData);
    }

    public function list(): array
    {
        return $this->repository->list();
    }
}
