<?php
declare(strict_types=1);

namespace Api\Model\Vehicle;

use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testShouldCreateNewCategory()
    {
        $categoryData = [
            'name' => 'Category Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Vehicle\\Category')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($categoryData);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Category')
            ->disableOriginalConstructor()
            ->setMethods(['findByName', 'create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($categoryData['name'])
            ->willReturn(null);

        $newCategoryData = ['id' => 12] + $categoryData;

        $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($categoryData)
            ->willReturn($newCategoryData);

        $categoryModel = new Category($mockValidator, $mockRepository);

        $retrieveData = $categoryModel->create($categoryData);

        $this->assertEquals($newCategoryData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $categoryData = [
            'id'    => '123',
            'name'  => 'Category Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Vehicle\\Category')
            ->setMethods(['validate'])
            ->getMock();

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Category')
            ->disableOriginalConstructor()
            ->setMethods(['list'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('list')
            ->willReturn($categoryData);

        $categoryModel = new Category($mockValidator, $mockRepository);

        $retrieveData = $categoryModel->list();

        $this->assertEquals($categoryData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\ValidatorException
     */
    public function testShouldGetErrorWhenNameIsAlreadyInUse()
    {
        $categoryData = [
            'name' => 'Category Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Vehicle\\Category')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($categoryData);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Category')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($categoryData['name'])
            ->willReturn($categoryData);

        $categoryModel = new Category($mockValidator, $mockRepository);

        $categoryModel->create($categoryData);
    }
}
