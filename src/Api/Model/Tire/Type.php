<?php
declare(strict_types=1);

namespace Api\Model\Tire;

use Api\Validator\Tire\Type as TypeValidator;
use Api\Repository\Tire\Type as TypeRepository;
use Api\Exception\ValidatorException;

/**
 * @Entity @Table(name="tire_type")
 **/
class Type
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
            $exception = new ValidatorException('This tire type name already exists.');
            throw $exception;
        }

        return $this->repository->create($typeData);
    }

    public function list(): array
    {
        return $this->repository->list();
    }
}
