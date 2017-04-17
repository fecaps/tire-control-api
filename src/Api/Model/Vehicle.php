<?php
declare(strict_types=1);

namespace Api\Model;

use Api\Validator\Vehicle as VehicleValidator;
use Api\Repository\Vehicle as VehicleRepository;
use Api\Repository\Vehicle\Type as TypeRepository;
use Api\Repository\Vehicle\Brand as BrandRepository;
use Api\Repository\Vehicle\Model as ModelRepository;
use Api\Repository\Vehicle\Category as CategoryRepository;
use Api\Exception\ValidatorException;

class Vehicle
{
    private $validator;
    private $typeRepository;
    private $brandRepository;
    private $modelRepository;
    private $categoryRepository;
    private $repository;
    
    public function __construct(
        VehicleValidator $validator,
        TypeRepository $typeRepository,
        BrandRepository $brandRepository,
        ModelRepository $modelRepository,
        CategoryRepository $categoryRepository,
        VehicleRepository $repository
    ) {
        $this->validator            = $validator;
        $this->typeRepository       = $typeRepository;
        $this->brandRepository      = $brandRepository;
        $this->modelRepository      = $modelRepository;
        $this->categoryRepository   = $categoryRepository;
        $this->repository           = $repository;
    }

    public function create(array $vehicleData): array
    {
        $exception = new ValidatorException;

        $this->validator->validate($vehicleData);

        $type       = $vehicleData['type'];
        $brand      = $vehicleData['brand'];
        $model      = $vehicleData['model'];
        $category   = $vehicleData['category'];
        $plate      = $vehicleData['plate'];

        $existsType = $this->typeRepository->findByName($type);

        $existsBrand = $this->brandRepository->findByName($brand);

        $existsModel = $this->modelRepository->findByName($model);

        $existsCategory = $this->categoryRepository->findByName($category);

        $existsPlate = $this->repository->findByPlate($plate);

        if (!$existsType) {
            $exception->addMessage('type', 'The type must be registered in the vehicle type table.');
        }

        if (!$existsBrand) {
            $exception->addMessage('brand', 'The brand must be registered in the vehicle brand table.');
        }
         
        if (!$existsModel) {
            $exception->addMessage('model', 'The model must be registered in the vehicle model table.');
        }

        if (!$existsCategory) {
            $exception->addMessage('category', 'The category must be registered in the vehicle category table.');
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
