<?php
declare(strict_types=1);

namespace Api\Controller\Vehicle;

use Symfony\Component\HttpFoundation\Request;
use Api\Model\Vehicle\Model;

class ModelController
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(Request $request): array
    {
        $data = $request->request->all();

        $model = $this->model->create($data);
        
        $returnData = [
            'id'    => $model['id'],
            'brand' => $model['brand'],
            'model' => $model['model']
        ];

        return $returnData;
    }

    public function list(): array
    {
        return ['data' => $this->model->list()];
    }
}
