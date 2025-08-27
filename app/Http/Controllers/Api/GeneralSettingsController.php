<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Settings\GeneralSettings;

class GeneralSettingsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/settings/general",
     *     summary="نمایش تنظیمات عمومی سایت",
     *     description="این اندپوینت اطلاعات تنظیمات عمومی مانند نام سایت، شماره تماس، ساعات کاری و ... را برمی‌گرداند.",
     *     tags={"Settings"},
     *     @OA\Response(
     *         response=200,
     *         description="تنظیمات عمومی با موفقیت برگردانده شد.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="site_name", type="string", example="کافه رز"),
     *             @OA\Property(property="instagram_id", type="string", example="@caferose"),
     *             @OA\Property(property="master_mobile", type="string", example="09121234567"),
     *             @OA\Property(property="about", type="string", example="این کافه از سال ۱۴۰۰ فعالیت خود را آغاز کرده است."),
     *             @OA\Property(property="contact", type="string", example="تهران، خیابان انقلاب، پلاک ۱۲"),
     *             @OA\Property(property="work_hours", type="string", example="هر روز ۸ صبح تا ۱۱ شب")
     *         )
     *     )
     * )
     */
    public function __invoke(GeneralSettings $settings)
    {
        return response()->json([
            'site_name'     => $settings->init_site_name,
            'instagram_id'  => $settings->instagram_id,
            'master_mobile' => $settings->master_mobile,
            'about'         => $settings->about,
            'contact'       => $settings->contact,
            'work_hours'    => $settings->work_hours,
        ]);
    }
}
