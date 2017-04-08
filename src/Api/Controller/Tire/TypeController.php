<?php
declare(strict_types=1);

namespace Api\Controller\Tire;

use Symfony\Component\HttpFoundation\Request;
use Api\Model\Tire\Type;

class TypeController
{
    private $type;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    public function register(Request $request): array
    {
        $data = $request->request->all();

        $type = $this->type->create($data);
        
        $returnData = [
            'name' => $type['name'],
        ];

        return $returnData;
    }
}
