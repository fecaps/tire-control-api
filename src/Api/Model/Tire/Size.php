<?php
declare(strict_types=1);

namespace Api\Model\Tire;

use Api\Validator\Tire\Size as SizeValidator;
use Api\Repository\Tire\Size as SizeRepository;
use Api\Exception\ValidatorException;

/**
 * @Entity @Table(name="tire_size")
 **/
class Size
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
    
    public function __construct(SizeValidator $validator, SizeRepository $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function create(array $sizeData): array
    {
        $this->validator->validate($sizeData);

        $size = $sizeData['name'];

        $existsName = $this->repository->findByName($size);

        if ($existsName) {
            $exception = new ValidatorException('This size name already exists.');
            throw $exception;
        }

        return $this->repository->create($sizeData);
    }

    public function list(): array
    {
        return $this->repository->list();
    }
}
