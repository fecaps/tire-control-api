<?php

declare(strict_types=1);

namespace Api\Controller\Tire;

use Symfony\Component\HttpFoundation\Request;
use Api\Model\Tire\Tire;

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
            'brand_id'          => $tire['brand_id'],
            'model_id'          => $tire['model_id'],
            'size_id'           => $tire['size_id'],
            'type_id'           => $tire['type_id'],
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
