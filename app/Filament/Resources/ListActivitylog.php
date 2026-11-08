<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomActivitylogResource;
use Rmsramos\Activitylog\Resources\Activitylog\Pages\ListActivitylog as BaseListActivitylog;

class ListActivitylog extends BaseListActivitylog
{
    protected static string $resource = CustomActivitylogResource::class;
}
