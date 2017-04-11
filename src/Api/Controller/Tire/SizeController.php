<?php
declare(strict_types=1);

namespace Api\Controller\Tire;

use Symfony\Component\HttpFoundation\Request;
use Api\Model\Tire\Size;

class SizeController
{
    private $size;

    public function __construct(Size $size)
    {
        $this->size = $size;
    }

    public function create(Request $request): array
    {
        $data = $request->request->all();

        $size = $this->size->create($data);
        
        $returnData = [
            'id'    => $size['id'],
            'name'  => $size['name']
        ];

        return $returnData;
    }

    public function list(): array
    {
        return $this->size->list();
    }
}
