<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('back')
                ->url(fn () => route('admin.users.index'))
                ->icon('heroicon-o-arrow-left')
                ->label('Back to Users'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return route('admin.users.index');
    }
}
