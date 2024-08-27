<?php

declare(strict_types=1);

namespace Src\Category\Infrastructure\Controller;

use Core\Container;
use Src\Category\Aplication\UseCase\GetCategory;
use Src\Category\Aplication\UseCase\GetCategories;
use Src\User\Aplication\UseCase\RegisterCategory;
use Src\Shader\Infrastructure\Utils\QueryParams;

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
        echo json_encode($categories);
    }

    public function show(int $categoryId)
    {
        $getCategory = $this->container->get(GetCategory::class);
        $category = $getCategory->execute($categoryId);
        echo json_encode($category);
    }

}