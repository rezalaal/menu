<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Models\Product;
use App\Models\Category;
use Filament\Tables\Table;
use Filament\Actions\DeleteAction;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategoryResource;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Relations\Relation;
use IbrahimBougaoua\FilamentSortOrder\Actions\UpStepAction;
use IbrahimBougaoua\FilamentSortOrder\Actions\DownStepAction;

class EditCategory extends EditRecord implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = CategoryResource::class;

        
    public function getFooter():View
    {
        return view('filament.categories.customer-footer');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }    
    
    public function table(Table $table): Table
    {
        return $table
            ->query(Product::orderBy('sort_order')->where('category_id', $this->getRecord()->id))
            ->columns([
                TextColumn::make('name')
                    ->label('عنوان محصول')
                    ->searchable(),
                TextInputColumn::make('sort_order')
                    ->rules(['required', 'numeric','min:0'])
                    ->label('ترتیب'),
            ])
            ->actions([
                Action::make('Up')
                    ->icon('heroicon-o-arrow-up')
                    ->iconButton()
                    ->action(function (Model $record) {
                        if($record->sort_order !=0) {
                            $record->sort_order -= 1;
                            $record->save();
                        }                        
                    }),
                Action::make('Down')
                    ->icon('heroicon-o-arrow-down')
                    ->iconButton()
                    ->action(function (Model $record) {                        
                        $record->sort_order += 1;
                        $record->save();
                    })
            ])
            ->defaultSort('sort_order', 'asc')
            ->paginated(false);
    }
    
}
