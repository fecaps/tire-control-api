<?php
declare(strict_types=1);

namespace Api\Model\Vehicle;

use Api\Validator\Vehicle\Vehicle as VehicleValidator;
use Api\Repository\Vehicle as VehiclesRepository;
use Api\Exception\ValidatorException;

/**
 * @Entity @Table(name="vehicle")
 **/
class Vehicle
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Many Vehicle has One Brand.
     * @ManyToOne(targetEntity="Brand")
     * @JoinColumn(name="brand_id", referencedColumnName="id")
     */
    private $brand;

    /**
     * Many Vehicle has One Category.
     * @ManyToOne(targetEntity="Category")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * Many Vehicle has One Model.
     * @ManyToOne(targetEntity="Model")
     * @JoinColumn(name="model_id", referencedColumnName="id")
     */
    private $model;

    /**
     * Many Vehicle has One Type.
     * @ManyToOne(targetEntity="Type")
     * @JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @Column(type="string", length=100, unique=true, nullable=false)
     */
    private $plate;

    private $validator;

    private $typeRepository;

    private $brandRepository;

    private $categRepository;

    private $modelRepository;

    private $repository;
    
    public function __construct(
        VehicleValidator            $validator,
        VehiclesRepository\Brand    $brandRepository,
        VehiclesRepository\Category $categRepository,
        VehiclesRepository\Model    $modelRepository,
        VehiclesRepository\Type     $typeRepository,
        VehiclesRepository\Vehicle  $repository
    ) {
        $this->validator        = $validator;
        $this->brandRepository  = $brandRepository;
        $this->categRepository  = $categRepository;
        $this->modelRepository  = $modelRepository;
        $this->typeRepository   = $typeRepository;
        $this->repository       = $repository;
    }

    public function create(array $vehicleData): array
    {
        $exception = new ValidatorException;

        $this->validator->validate($vehicleData);

        $brand      = $vehicleData['brand_id'];
        $category   = $vehicleData['category_id'];
        $model      = $vehicleData['model_id'];
        $type       = $vehicleData['type_id'];
        $plate      = $vehicleData['plate'];

        $existsBrand = $this->brandRepository->findById($brand);

        $existsCateg = $this->categRepository->findById($category);

        $existsModel = $this->modelRepository->findById($model);

        $existsType = $this->typeRepository->findById($type);

        $existsPlate = $this->repository->findByPlate($plate);

        if (!$existsBrand) {
            $exception->addMessage('brand', 'The brand_id must be registered in the vehicle brand table.');
        }
         
        if (!$existsCateg) {
            $exception->addMessage('category', 'The category_id must be registered in the vehicle category table.');
        }

        if (!$existsModel) {
            $exception->addMessage('model', 'The model_id must be registered in the vehicle model table.');
        }

        if (!$existsType) {
            $exception->addMessage('type', 'The type must_id be registered in the vehicle type table.');
        }

        if ($existsPlate) {
            $exception->addMessage('plate', 'The plate is already in use.');
        }

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }

        return $this->repository->create($vehicleData);
    }

    public function list(): array
    {
        return $this->repository->list();
    }
}
