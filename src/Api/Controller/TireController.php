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

    public function create(Request $request): array
    {
        $data = $request->request->all();

        $tire = $this->tire->create($data);
        
        $returnData = [
            'id'                => $tire['id'],
            'brand'             => $tire['brand'],
            'model'             => $tire['model'],
            'size'              => $tire['size'],
            'type'              => $tire['type'],
            'dot'               => $tire['dot'],
            'code'              => $tire['code'],
            'purchase_price'    => $tire['purchase_price'],
            'purchase_date'     => $tire['purchase_date']
        ];

        return $returnData;
    }

    public function list(): array
    {
        return ['data' => $this->tire->list()];
    }
}
