<?php
declare(strict_types=1);

namespace Api\Controller\Vehicle;

use Symfony\Component\HttpFoundation\Request;
use Api\Model\Vehicle\Category;

class CategoryController
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function create(Request $request): array
    {
        $data = $request->request->all();

        $category = $this->category->create($data);
        
        $returnData = [
            'id'    => $category['id'],
            'name'  => $category['name']
        ];

        return $returnData;
    }

    public function list(): array
    {
        return ['data' => $this->category->list()];
    }
}
