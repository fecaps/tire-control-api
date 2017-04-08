<?php
declare(strict_types=1);

namespace Api\Controller\Tire;

use Symfony\Component\HttpFoundation\Request;
use Api\Model\Tire\Model;

class ModelController
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function register(Request $request): array
    {
        $data = $request->request->all();

        $model = $this->model->create($data);
        
        $returnData = [
            'name' => $model['name'],
        ];

        return $returnData;
    }
}