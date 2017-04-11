<?php
declare(strict_types=1);

namespace Api\Controller\Tire;

use Symfony\Component\HttpFoundation\Request;
use Api\Model\Tire\Brand;

class BrandController
{
    private $brand;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function create(Request $request): array
    {
        $data = $request->request->all();

        $brand = $this->brand->create($data);
        
        $returnData = [
            'id'    => $brand['id'],
            'name'  => $brand['name']
        ];

        return $returnData;
    }

    public function list(): array
    {
        return $this->brand->list();
    }
}
