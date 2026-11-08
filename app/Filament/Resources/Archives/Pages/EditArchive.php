<?php

namespace App\Filament\Resources\Archives\Pages;

use App\Filament\Resources\Archives\ArchiveResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditArchive extends EditRecord
{
    protected static string $resource = ArchiveResource::class;

    public function form(Schema $schema): Schema
    {
        return ArchiveResource::form($schema);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($this->record->approval_status === 'rejected') {
            $data['approval_status'] = 'pending';
            $data['rejection_note'] = null;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return url('/admin/archives/pending');
    }
}
