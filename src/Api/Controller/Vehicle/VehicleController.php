<?php

declare(strict_types=1);

namespace Api\Controller\Vehicle;

use Symfony\Component\HttpFoundation\Request;
use Api\Model\Vehicle\Vehicle;

class VehicleController
{
    private $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function create(Request $request): array
    {
        $data = $request->request->all();

        $vehicle = $this->vehicle->create($data);
        
        $returnData = [
            'id'            => $vehicle['id'],
            'brand_id'      => $vehicle['brand_id'],
            'category_id'   => $vehicle['category_id'],
            'model_id'      => $vehicle['model_id'],
            'type_id'       => $vehicle['type_id'],
            'plate'         => $vehicle['plate']
        ];

        return $returnData;
    }

    public function list(): array
    {
        return ['data' => $this->vehicle->list()];
    }
}
