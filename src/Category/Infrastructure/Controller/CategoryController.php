<?php

declare(strict_types=1);

namespace Src\Category\Infrastructure\Controller;

use Core\Container;
use Src\Category\Aplication\UseCase\RegisterCategory;
use Src\Category\Aplication\UseCase\GetCategory;
use Src\Category\Aplication\UseCase\GetCategories;
use Src\Category\Aplication\DTO\CategoryRequest;
use Src\Shader\Infrastructure\Utils\QueryParams;
use Src\Category\Aplication\UseCase\UpdateCategory;
use Src\Category\Aplication\UseCase\DeleteCategory;
use Src\Shader\Infrastructure\Utils\SuccessMessage;

class CategoryController
{
    public function __construct(
        private Container $container,
    ) {}

    public function index()
    {
        $name = QueryParams::query('name');
        $params['name'] = [
            'operator' => 'LIKE',
            'value' => $name,
        ];
        $getCategories = $this->container->get(GetCategories::class);
        $categories = $getCategories->execute($params);

        SuccessMessage::successMessage("OK", $categories);
    }

    public function show(int $categoryId)
    {
        $getCategory = $this->container->get(GetCategory::class);
        $category = $getCategory->execute($categoryId);

        SuccessMessage::successMessage("OK", $category);
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $categoryRequest = new CategoryRequest(
            name: $data['name'],
            description: $data['description']
        );
    
        $registerCategory = $this->container->get(RegisterCategory::class);
        $registerCategory->execute($categoryRequest);

        SuccessMessage::successMessage("registrada");
    }

    public function update(int $categoryId)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $categoryRequest = new CategoryRequest(
            name: $data['name'],
            description: $data['description']
        );

        $updateCategory = $this->container->get(UpdateCategory::class);
        $updateCategory->execute($categoryId, $categoryRequest);

        SuccessMessage::successMessage("actualizada");
    }

    public function delete(int $categoryId)
    {
        $deleteCategory = $this->container->get(DeleteCategory::class);
        $deleteCategory->execute($categoryId);

        SuccessMessage::successMessage("eliminada");
    }
}