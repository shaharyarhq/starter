<?php

declare(strict_types=1);

namespace App\Providers;

use App\Filament\Support\View\LucideLoadingIndicator;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Support\Contracts\LoadingIndicator;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ColumnManagerLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->configureTable();
        $this->configureSchema();
        $this->configureActions();
        // $this->translatableComponents();
        Model::automaticallyEagerLoadRelationships();
    }

    // private function translatableComponents(): void
    // {
    //     foreach ([Field::class, BaseFilter::class, Column::class, Entry::class] as $component) {
    //         /* @var Configurable $component */
    //         $component::configureUsing(function (Component $translatable): void {
    //             /** @phpstan-ignore method.notFound */
    //             $translatable->translateLabel();
    //         });
    //     }
    // }

    private function configureTable(): void
    {
        Table::configureUsing(function (Table $table): void {
            $table->striped()
                ->deferLoading(false)
                ->defaultDateDisplayFormat(app_date_format())
                ->defaultDateTimeDisplayFormat(app_date_time_format())
                ->defaultSort('created_at', 'desc')
                ->reorderableColumns()
                ->columnManagerLayout(ColumnManagerLayout::Modal)
                ->columnManagerTriggerAction(fn(Action $action): Action => $action->slideOver())
                ->paginationPageOptions([5, 10, 25, 50, 100])
                // ->deferFilters()
                // ->deferColumnManager()
                // ->deferLoading()
                ->filtersTriggerAction(
                    fn(Action $action) => $action
                        ->slideOver() // This makes the filter panel a slide-over
                )
                ->filtersFormColumns(2)
                ->searchable();
        });

        TextColumn::configureUsing(function (TextColumn $column): void {
            $column
                ->searchable()
                ->sortable()
                ->toggleable()
                ->placeholder('---');
        });
    }

    private function configureSchema()
    {
        Select::configureUsing(function (Select $select): void {
            $select
                ->searchable()
                ->preload()
                ->optionsLimit(10);
        });
    }

    private function configureActions()
    {
        $this->app->bind(LoadingIndicator::class, LucideLoadingIndicator::class);

        CreateAction::configureUsing(function (CreateAction $action) {
            $action->icon(Heroicon::Plus);
        });

        DeleteAction::configureUsing(function (DeleteAction $action) {
            $action->icon(Heroicon::Trash);
        });

        ViewAction::configureUsing(function (ViewAction $action) {
            $action->icon(Heroicon::Eye);
        });

        EditAction::configureUsing(function (EditAction $action) {
            $action->icon(Heroicon::Pencil);
        });
    }
}
