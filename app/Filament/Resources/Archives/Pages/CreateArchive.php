<?php

namespace App\Filament\Resources\Archives\Pages;

use App\Filament\Resources\Archives\ArchiveResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateArchive extends CreateRecord
{
    protected static string $resource = ArchiveResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Tambah Arsip';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-plus-circle';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Arsip';
    }

    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        return true;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        $user = Auth::user();

        if ($user?->isSuperAdmin()) {
            return url('/admin/archives/approved');
        }

        if ($user?->isPetugas()) {
            return url('/admin/archives/pending');
        }

        return $this->getResource()::getUrl('index');
    }

    protected function hasCreateAnother(): bool
    {
        return false;
    }
}
