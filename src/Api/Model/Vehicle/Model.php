<?php
declare(strict_types=1);

namespace Api\Model\Vehicle;

use Api\Validator\Vehicle\Model as ModelValidator;
use Api\Repository\Vehicle as VehiclesRepository;
use Api\Exception\ValidatorException;

/**
 * @Entity @Table(name="vehicle_model_brand")
 **/
class Model
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Many Model has One Brand.
     * @OneToOne(targetEntity="Brand")
     * @JoinColumn(name="brand_id", referencedColumnName="id")
     */
    private $brand;

    /**
     * @Column(type="string", length=100, nullable=false)
     */
    private $model;

    private $validator;

    private $repository;

    private $brandRepository;
    
    public function __construct(
        ModelValidator $validator,
        VehiclesRepository\Brand $brandRepository,
        VehiclesRepository\Model $repository
    ) {
        $this->validator = $validator;
        $this->brandRepository = $brandRepository;
        $this->repository = $repository;
    }

    public function create(array $modelData): array
    {
        $exception = new ValidatorException;

        $this->validator->validate($modelData);

        $brand = $modelData['brand_id'];
        $model = $modelData['model'];

        $existsBrand = $this->brandRepository->findById($brand);

        if (!$existsBrand) {
            $exception->addMessage('brand_id', 'The brand_id must be registered in the vehicle brand table.');
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
