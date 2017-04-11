<?php
declare(strict_types=1);

namespace Api\Model;

use Api\Validator\Tire as TireValidator;
use Api\Repository\Tire as TireRepository;
use Api\Repository\Tire\Brand as BrandRepository;
use Api\Repository\Tire\Model as ModelRepository;
use Api\Repository\Tire\Size as SizeRepository;
use Api\Repository\Tire\Type as TypeRepository;
use Api\Exception\ValidatorException;

class Tire
{
    private $validator;
    private $brandRepository;
    private $modelRepository;
    private $sizeRepository;
    private $typeRepository;
    private $repository;
    
    public function __construct(
        TireValidator $validator,
        BrandRepository $brandRepository,
        ModelRepository $modelRepository,
        SizeRepository $sizeRepository,
        TypeRepository $typeRepository,
        TireRepository $repository
    ) {
        $this->validator        = $validator;
        $this->brandRepository  = $brandRepository;
        $this->modelRepository  = $modelRepository;
        $this->sizeRepository   = $sizeRepository;
        $this->typeRepository   = $typeRepository;
        $this->repository       = $repository;
    }

    public function create(array $tireData): array
    {
        $exception = new ValidatorException;

        $this->validator->validate($tireData);

        $brand = $tireData['brand'];
        $model = $tireData['model'];
        $size  = $tireData['size'];
        $type  = $tireData['type'];
        $code  = $tireData['code'];

        $existsBrand = $this->brandRepository->findByName($brand);

        $existsModel = $this->modelRepository->findByName($model);

        $existsSize = $this->sizeRepository->findByName($size);

        $existsType = $this->typeRepository->findByName($type);

        $existsCode = $this->repository->findByCode($code);

        if (!$existsBrand) {
            $exception->addMessage('brand', 'The brand must be registered in the brands table.');
        }
         
        if (!$existsModel) {
            $exception->addMessage('model', 'The model must be registered in the models table.');
        }

        if (!$existsSize) {
            $exception->addMessage('size', 'The size must be registered in the sizes table.');
        }

        if (!$existsType) {
            $exception->addMessage('type', 'The type must be registered in the types table.');
        }

        if ($existsCode) {
            $exception->addMessage('code', 'Code already in use.');
        }

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }

        return $this->repository->create($tireData);
    }

    public function list(): array
    {
        return $this->repository->list();
    }
}
