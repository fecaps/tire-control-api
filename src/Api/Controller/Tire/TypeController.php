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

    public function create(Request $request): array
    {
        $data = $request->request->all();

        $type = $this->type->create($data);
        
        $returnData = [
            'id'    => $type['id'],
            'name'  => $type['name']
        ];

        return $returnData;
    }

    public function list(): array
    {
        return $this->type->list();
    }
}
