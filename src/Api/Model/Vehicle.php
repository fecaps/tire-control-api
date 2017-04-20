<?php
declare(strict_types=1);

namespace Api\Model;

use Api\Validator\Vehicle as VehicleValidator;
use Api\Repository\Vehicle as VehicleRepository;
use Api\Repository\Vehicle\Type as TypeRepository;
use Api\Repository\Vehicle\Brand as BrandRepository;
use Api\Repository\Vehicle\Model as ModelRepository;
use Api\Repository\Vehicle\Category as CategRepository;
use Api\Exception\ValidatorException;

class Vehicle
{
    private $validator;
    private $typeRepository;
    private $brandRepository;
    private $categRepository;
    private $modelRepository;
    private $repository;
    
    public function __construct(
        VehicleValidator $validator,
        BrandRepository $brandRepository,
        CategRepository $categRepository,
        ModelRepository $modelRepository,
        typeRepository  $typeRepository,
        VehicleRepository $repository
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

        $brand      = $vehicleData['brand'];
        $category   = $vehicleData['category'];
        $model      = $vehicleData['model'];
        $type       = $vehicleData['type'];
        $plate      = $vehicleData['plate'];

        $existsBrand = $this->brandRepository->findByName($brand);

        $existsCateg = $this->categRepository->findByName($category);

        $existsModel = $this->modelRepository->findByModel($model);

        $existsType = $this->typeRepository->findByName($type);

        $existsPlate = $this->repository->findByPlate($plate);

        if (!$existsBrand) {
            $exception->addMessage('brand', 'The brand must be registered in the vehicle brand table.');
        }
         
        if (!$existsCateg) {
            $exception->addMessage('category', 'The category must be registered in the vehicle category table.');
        }

        if (!$existsModel) {
            $exception->addMessage('model', 'The model must be registered in the vehicle model table.');
        }

        if (!$existsType) {
            $exception->addMessage('type', 'The type must be registered in the vehicle type table.');
        }

        if ($existsPlate) {
            $exception->addMessage('plate', 'Plate already in use.');
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
