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

    public function register(Request $request): array
    {
        $data = $request->request->all();

        $brand = $this->brand->create($data);
        
        $returnData = [
            'id'    => $brand['id'],
            'name'  => $brand['name']
        ];

        return $returnData;
    }

    public function selectAll(Request $request): array
    {
        $data = $request->request->all();

        $returnData = $this->brand->selectAll();
        
        return $returnData;
    }
}
