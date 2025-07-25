<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OpenAiService;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Cache;


class AiOffer extends Controller
{

public function __invoke(Request $request, OpenAiService $aiService, GeneralSettings $generalSettings)
{
    $user = auth()->user();

    if (!$user) {
        return response()->json([
            'offer' => null
        ]);
    }

    $cacheKey = "ai_offer_last_time_{$user->id}";
    $lastTime = Cache::get($cacheKey);

    if ($lastTime && Carbon::parse($lastTime)->diffInHours(Carbon::now()) < 4) {
        return response()->json([
            'offer' => null,
            'message' => 'پیشنهاد جدید در دسترس نیست. لطفا بعدا دوباره تلاش کنید.'
        ]);
    }

    // جمع آوری علاقه‌مندی‌ها
    $favorites = $user->favorites()->pluck('name')->toArray();

    // جمع آوری محصولات سفارش‌های قبلی
    $orderedProducts = $user->orders()
        ->with('orderLines.product')
        ->get()
        ->pluck('orderLines.*.product.name')
        ->flatten()
        ->unique()
        ->toArray();

    // ترکیب علاقه‌مندی‌ها و سفارش‌ها
    $userProducts = array_unique(array_merge($favorites, $orderedProducts));

    // لیست همه محصولات با id
    $allProducts = Product::query()
        ->select(['id', 'name'])
        ->get()
        ->map(function ($product) {
            return "{$product->name} (کد: {$product->code}, لینک: /product/{$product->id})";
        })
        ->toArray();

    // تشخیص زمان روز بر اساس ساعت تهران
    $hourTehran = Carbon::now('Asia/Tehran')->hour;
    if ($hourTehran >= 5 && $hourTehran < 11) {
        $meal = 'صبحانه';
    } elseif ($hourTehran >= 11 && $hourTehran < 15) {
        $meal = 'ناهار';
    } elseif ($hourTehran >= 15 && $hourTehran < 19) {
        $meal = 'عصرانه';
    } else {
        $meal = 'شام';
    }

    $userNamePart = '';
    if ($user->name && $user->name !== $user->username) {
        $userNamePart = "نام کاربر: {$user->name}، ";
    }

    $title = optional($generalSettings)->init_site_name ?? 'کافه';

    $content = "{$userNamePart}این کاربر سابقه علاقه‌مندی‌ها: " 
        . (!empty($userProducts) ? implode('، ', $userProducts) : 'ندارد') 
        . " را دارد. از بین لیست کل محصولات: "
        . implode('، ', $allProducts)
        . " یک پیشنهاد خاص، صمیمی و دوستانه از طرف گارسون و کارشناس تغذیه برای او ارائه کن. "
        . "پیشنهاد شامل تخفیف نباشد. "
        . "همچنین این پیشنهاد مناسب {$meal} باشد چون الان زمان {$meal} است.  "
        . " از ایموجی هم استفاده کن"
        ." و در نهایت از طرف {$title} یه آرزوی خوب واسه اش داشته باش";

    info('AI Offer prompt:', ['content' => $content]);

    $aiResponse = $aiService->generateOffer($content);

    // ذخیره زمان دریافت پیشنهاد در کش
    Cache::put($cacheKey, Carbon::now()->toDateTimeString(), now()->addHours(4));

    return response()->json([
        'offer' => $aiResponse
    ]);
}

}
