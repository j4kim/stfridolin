<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Tools\Helpers;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Field;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Infolists\Components\Entry;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Components\Component;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Table;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->passwordReset()
            ->profile()
            ->colors([
                'primary' => Color::Violet,
            ])
            ->favicon(asset('favicon-inverted.svg'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationItems([
                NavigationItem::make("Cartes d'invités")
                    ->url(fn() => route('vue-app', 'guest-cards'))
                    ->icon(Heroicon::Printer)
                    ->group('Outils')
                    ->sort(9000),
                NavigationItem::make("Cartes bons")
                    ->url(fn() => route('vue-app', 'voucher-cards'))
                    ->icon(Heroicon::Printer)
                    ->group('Outils')
                    ->sort(9100),
                NavigationItem::make('Scan')
                    ->url(fn() => route('vue-app', 'qr-scan'))
                    ->icon(Heroicon::QrCode)
                    ->group('Outils')
                    ->sort(9500),
            ])
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
                fn(): string => Blade::render("<x-filament::link href=\"/\" style=\"text-align:center\">Vers app</x-filament::link>"),
            )->renderHook(
                PanelsRenderHook::SIDEBAR_FOOTER,
                fn(): string  => "<span style=\"opacity:0.4; font-size:10px; padding: 8px;\">v" . config('app.version') . "</span>",
            );
    }

    public function boot(): void
    {
        Table::configureUsing(function (Table $table): void {
            $table
                ->reorderableColumns()
                ->paginationPageOptions([10, 25, 50, 100, 'all'])
                ->extremePaginationLinks()
                ->persistSortInSession()
                ->recordActions([
                    ViewAction::make(),
                    EditAction::make(),
                ])
                ->toolbarActions([
                    BulkActionGroup::make([
                        DeleteBulkAction::make(),
                    ]),
                ])
                ->summaries(
                    pageCondition: false
                )
                ->deferFilters(false)
                ->deferColumnManager(false)
                ->stackedOnMobile();
        });

        Column::configureUsing(fn(Component $c) => Helpers::setLabel($c));
        Entry::configureUsing(fn(Component $c) => Helpers::setLabel($c));
        Field::configureUsing(fn(Component $c) => Helpers::setLabel($c));
        BaseFilter::configureUsing(fn(Component $c) => Helpers::setLabel($c));
        Action::configureUsing(fn(Component $c) => Helpers::setLabel($c));
    }
}
