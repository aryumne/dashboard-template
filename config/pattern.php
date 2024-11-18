<?php

return [
    "models" => [
        "Category" => [
            "repository" => \App\Repositories\CategoryRepository::class,
            "service"    => \App\Services\CategoryService::class,
        ],
        "BaseModel" => [
            "repository" => \App\Repositories\BaseModelRepository::class,
            "service"    => \App\Services\BaseModelService::class,
        ],
        "Season" => [
            "repository" => \App\Repositories\SeasonRepository::class,
            "service"    => \App\Services\SeasonService::class,
        ],
        "TdCode" => [
            "repository" => \App\Repositories\TdCodeRepository::class,
            "service"    => \App\Services\TdCodeService::class,
        ],
        "Stage" => [
            "repository" => \App\Repositories\StageRepository::class,
            "service"    => \App\Services\StageService::class,
        ],
        "Stage" => [
            "repository" => \App\Repositories\StageRepository::class,
            "service"    => \App\Services\StageService::class,
        ],
        "Project" => [
            "repository" => \App\Repositories\ProjectRepository::class,
            "service"    => \App\Services\ProjectService::class,
        ],
        "Product" => [
            "repository" => \App\Repositories\ProjectRepository::class,
            "service"    => \App\Services\ProjectService::class,
        ],
        "Component" => [
            "repository" => \App\Repositories\ProjectRepository::class,
            "service"    => \App\Services\ProjectService::class,
        ],
        "ProductUploadLog" => [
            "repository" => \App\Repositories\ProjectRepository::class,
            "service"    => \App\Services\ProjectService::class,
        ],
    ]
];
