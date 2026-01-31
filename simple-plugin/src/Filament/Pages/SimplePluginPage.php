<?php

namespace NexusPlugin\SimplePlugin\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class SimplePluginPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-plugin';

    protected static string $routePath = 'simple-plugin';

    protected static ?string $navigationGroup = 'Plugins';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Simple Plugin';

    protected static string $view = 'simple-plugin::filament.pages.simple-plugin';

    public function getTitle(): string|Htmlable
    {
        return __('Simple Plugin');
    }

    public static function getNavigationLabel(): string
    {
        return __('Simple Plugin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}