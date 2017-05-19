<?php
declare(strict_types=1);

namespace Api\Model\Tire;

use Api\Validator\Tire\Tire as TireValidator;
use Api\Repository\Tire as TiresRepository;
use Api\Exception\ValidatorException;

/**
 * @Entity @Table(name="tire")
 **/
class Tire
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * Many Tire has One Brand.
     * @ManyToOne(targetEntity="Brand")
     * @JoinColumn(name="brand_id", referencedColumnName="id")
     */
    private $brand;

    /**
     * Many Tire has One Model.
     * @ManyToOne(targetEntity="Model")
     * @JoinColumn(name="model_id", referencedColumnName="id")
     */
    private $model;

    /**
     * Many Tire has One Size.
     * @ManyToOne(targetEntity="Size")
     * @JoinColumn(name="size_id", referencedColumnName="id")
     */
    private $size;

    /**
     * Many Tire has One Type.
     * @ManyToOne(targetEntity="Type")
     * @JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @Column(type="string", length=100, nullable=false)
     */
    private $dot;

    /**
     * @Column(type="string", length=100, unique=true, nullable=false)
     */
    private $code;

    /**
     * @Column(type="float", name="purchase_price", nullable=false)
     */
    private $purchasePrice;

    /**
     * @Column(type="date", name="purchase_date", nullable=false)
     */
    private $purchaseDate;
    
    private $validator;

    private $brandRepository;
    
    private $modelRepository;
    
    private $sizeRepository;
    
    private $typeRepository;
    
    private $repository;

    public function __construct(
        TireValidator           $validator,
        TiresRepository\Brand   $brandRepository,
        TiresRepository\Model   $modelRepository,
        TiresRepository\Size    $sizeRepository,
        TiresRepository\Type    $typeRepository,
        TiresRepository\Tire    $repository
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

        $brand = $tireData['brand_id'];
        $model = $tireData['model_id'];
        $size  = $tireData['size_id'];
        $type  = $tireData['type_id'];
        $code  = $tireData['code'];

        $existsBrand = $this->brandRepository->findById($brand);

        $existsModel = $this->modelRepository->findById($model);

        $existsSize = $this->sizeRepository->findById($size);

        $existsType = $this->typeRepository->findById($type);

        $existsCode = $this->repository->findByCode($code);

        if (!$existsBrand) {
            $exception->addMessage('brand_id', 'The brand_id must be registered in the tire brand table.');
        }
         
        if (!$existsModel) {
            $exception->addMessage('model_id', 'The model_id must be registered in the tire model table.');
        }

        if (!$existsSize) {
            $exception->addMessage('size_id', 'The size_id must be registered in the tire size table.');
        }

        if (!$existsType) {
            $exception->addMessage('type_id', 'The type_id must be registered in the tire type table.');
        }

        if ($existsCode) {
            $exception->addMessage('code', 'The code is already in use.');
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
