<?php

declare(strict_types=1);

namespace Api\Controller;

use Symfony\Component\HttpFoundation\Request;
use Api\Model\Tire;

class TireController
{
    private $tire;

    public function __construct(Tire $tire)
    {
        $this->tire = $tire;
    }

    public function register(Request $request): array
    {
        $data = $request->request->all();

        $tire = $this->tire->create($data);
        
        $returnData = [
            'id'    => $tire['id'],
            'brand' => $tire['brand'],
            'model' => $tire['model'],
            'size'  => $tire['size'],
            'type'  => $tire['type'],
            'dot'   => $tire['dot'],
            'code'  => $tire['code']
        ];

        return $returnData;
    }

    public function selectAll(): array
    {
        return $this->tire->selectAll();
    }
}
