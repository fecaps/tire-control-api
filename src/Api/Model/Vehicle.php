<?php
declare(strict_types=1);

namespace Api\Model;

use Api\Validator\Vehicle as VehicleValidator;
use Api\Repository\Vehicle as VehicleRepository;
use Api\Repository\Vehicle\Type as TypeRepository;
use Api\Repository\Vehicle\Brand as BrandRepository;
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
        BrandRepository $brandRepository,
        CategoryRepository $categoryRepository,
        TypeRepository $typeRepository,
        VehicleRepository $repository
    ) {
        $this->validator            = $validator;
        $this->brandRepository      = $brandRepository;
        $this->categoryRepository   = $categoryRepository;
        $this->typeRepository       = $typeRepository;
        $this->repository           = $repository;
    }

    public function create(array $vehicleData): array
    {
        $exception = new ValidatorException;

        $this->validator->validate($vehicleData);

        $brand      = $vehicleData['brand'];
        $category   = $vehicleData['category'];
        $type       = $vehicleData['type'];
        $plate      = $vehicleData['plate'];

        $existsBrand = $this->brandRepository->findByName($brand);

        $existsCategory = $this->categoryRepository->findByName($category);

        $existsType = $this->typeRepository->findByName($type);

        $existsPlate = $this->repository->findByPlate($plate);

        if (!$existsBrand) {
            $exception->addMessage('brand', 'The brand must be registered in the vehicle brand table.');
        }
         
        if (!$existsCategory) {
            $exception->addMessage('category', 'The category must be registered in the vehicle category table.');
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
