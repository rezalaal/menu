<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            // 📥 دکمه خروجی اکسل
            Action::make('export_excel')
                ->label('دانلود لیست محصولات')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(route('filament.products.export')),

            // 📤 دکمه ورود گروهی قیمت‌ها
            Action::make('import_prices')
                ->label('ورود گروهی قیمت‌ها')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    FileUpload::make('file')
                        ->label('آپلود فایل اکسل')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                        ])
                        ->disk('local') // تاکید بر استفاده از دیسک local
                        ->storeFiles()
                        ->visibility('private') // اجباری نیست ولی بهتره
                        ->directory('temp')
                        ->required(),

                ])
                ->action(function (array $data) {
                    $fileName = $data['file']; // temp/filename.xlsx
                    $fullPath = Storage::path($fileName);

                    if (!Storage::exists($fileName)) {
                        Notification::make()
                            ->title('فایل یافت نشد')
                            ->body('فایل آپلودشده موجود نیست یا مشکلی در ذخیره‌سازی رخ داده است.')
                            ->danger()
                            ->send();
                        return;
                    }

                    // خواندن محتوای اکسل
                    $rows = Excel::toCollection(null, $fullPath)->first();
//                    dump($rows->toArray());  // ← بعد از Excel::toCollection
                    $updatedCount = 0;
                    $errors = [];

                    foreach ($rows as $index => $row) {
                        // رد کردن ردیف هدر (ردیف اول)
                        if ($index === 0) {
                            continue;
                        }

                        $id = $row[0] ?? null;
                        $price = $row[2] ?? 0;

                        // اگر قیمت خالی بود (null یا string خالی)، صفر بگذار
                        if (is_null($price) || $price === '') {
                            $price = 0;
                        }

                        if (!$id || !is_numeric($price)) {
                            $errors[] = "ردیف " . ($index + 2) . " نامعتبر بود.";
                            continue;
                        }

                        $product = Product::find($id);
                        if (!$product) {
                            $errors[] = "محصول با ID {$id} پیدا نشد.";
                            continue;
                        }

                        $product->update(['price' => $price]);
                        $updatedCount++;
                    }

                    Notification::make()
                        ->title('بروزرسانی قیمت‌ها')
                        ->success()
                        ->body("{$updatedCount} محصول با موفقیت بروزرسانی شد.")
                        ->send();

                    if (!empty($errors)) {
                        Notification::make()
                            ->title('برخی خطاها')
                            ->danger()
                            ->body(implode("\n", array_slice($errors, 0, 5))) // نمایش حداکثر ۵ خطا
                            ->send();
                    }

                    Storage::delete($fileName); // حذف فایل موقت
                })
                ->modalHeading('ورود گروهی قیمت محصولات')
                ->modalSubmitActionLabel('ثبت'),
        ];
    }
}
