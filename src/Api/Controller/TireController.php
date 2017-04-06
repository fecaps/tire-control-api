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
            'type'          => $tire['type'],
            'brand'         => $tire['brand'],
            'durability'    => $tire['durability'],
            'cost'          => $tire['cost'],
            'situation'     => $tire['situation']
        ];

        return $returnData;
    }
}
