<?php

namespace App\Filament\Resources\Archives\Pages;

use App\Filament\Resources\Archives\ArchiveResource;
use App\Models\Archive;
use Filament\Resources\Pages\ListRecords;
class ListArchives extends ListRecords
{
    protected static string $resource = ArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ///
        ];
    }

    public function getTableQuery(): ?\Illuminate\Database\Eloquent\Builder
    {
        return Archive::query()->forCurrentUser();
    }

    public function mount(): void
    {
        redirect('/admin/archives/pending');
    }
}
