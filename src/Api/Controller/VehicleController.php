<?php

declare(strict_types=1);

namespace Api\Controller;

use Symfony\Component\HttpFoundation\Request;
use Api\Model\Vehicle;

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
            'id'        => $vehicle['id'],
            'brand'     => $vehicle['brand'],
            'category'  => $vehicle['category'],
            'model'     => $vehicle['model'],
            'type'      => $vehicle['type'],
            'plate'     => $vehicle['plate']
        ];

        return $returnData;
    }

    public function list(): array
    {
        return ['data' => $this->vehicle->list()];
    }
}
