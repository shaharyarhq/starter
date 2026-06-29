<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use Filament\Auth\MultiFactor\App\AppAuthentication;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Js;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\View\View;
use Sanzgrapher\DraggableModal\DraggableModalPlugin;

final class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('')
            ->login(Login::class)
            ->spa()
            ->profile()
            ->multiFactorAuthentication(
                AppAuthentication::make()
                    ->recoverable(),
            )
            ->sidebarCollapsibleOnDesktop()
            ->simplePageMaxContentWidth(Width::Medium)
            ->maxContentWidth(Width::Full)
            // ->topNavigation()
            ->globalSearch(false)
            ->topbar(false)
            ->colors([
                'primary' => [
                    50  => 'rgb(235, 255, 239)',
                    100 => 'rgb(204, 255, 212)',
                    200 => 'rgb(153, 255, 170)',
                    300 => 'rgb(102, 255, 128)',
                    400 => 'rgb(51, 239, 97)',
                    500 => 'rgb(26, 231, 85)',
                    600 => 'rgb(1, 223, 74)',
                    700 => 'rgb(0, 192, 64)',
                    800 => 'rgb(0, 153, 51)',
                    900 => 'rgb(0, 102, 34)',
                    950 => 'rgb(0, 51, 17)',
                ],
                'danger'  => Color::Rose,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(PanelsRenderHook::CONTENT_BEFORE, fn(): View => view('partials.background-pattern'))
            ->renderHook(PanelsRenderHook::BODY_END, fn(): View => view('partials.background-pattern'))
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn(): View => view('partials.bprogress')
            )
            ->plugins([
                DraggableModalPlugin::make()
            ]);
    }
}
