<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // اگر تنظیمات عمومی (general) وجود ندارد، ابتدا ایجاد کن
        $settings = DB::table('settings')->where('group', 'general')->first();

        if (!$settings) {
            DB::table('settings')->insert([
                'group' => 'general',
                'name' => 'about',
                'payload' => json_encode(''), // مقدار اولیه
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // افزودن فیلدهای جدید به گروه general
        $fields = ['about', 'contact', 'work_hours'];

        foreach ($fields as $field) {
            $exists = DB::table('settings')
                ->where('group', 'general')
                ->where('name', $field)
                ->exists();

            if (!$exists) {
                DB::table('settings')->insert([
                    'group' => 'general',
                    'name' => $field,
                    'payload' => json_encode(''),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('settings')
            ->where('group', 'general')
            ->whereIn('name', ['about', 'contact', 'work_hours'])
            ->delete();
    }
};

