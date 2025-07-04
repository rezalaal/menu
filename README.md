# ☕ Simple Online Coffee Menu

### Powered by Laravel, Filament, Livewire & TailwindCSS

---

این پروژه یک نمونه ساده از منوی آنلاین برای یک کافه/قهوه‌خانه است که با استفاده از تکنولوژی‌های مدرن PHP و JavaScript ساخته شده و هدف آن صرفاً **آموزش و یادگیری** است.

> ⚠️ **این برنامه تنها برای اهداف آموزشی طراحی شده است. استفاده از آن در محیط‌های production یا تجاری توصیه نمی‌شود.**

---

## 🎯 ویژگی‌های اصلی

- نمایش آنلاین محصولات و قیمت‌ها به صورت زنده
- افزودن به سبد خرید (با استفاده از LocalStorage مرورگر)
- نمایش سبد خرید و جمع صورتحساب با Alpine و Livewire
- احراز هویت کاربران با استفاده از پیامک و کد یکبار مصرف (OTP)
- مدیریت کامل محصولات با استفاده از پنل ادمین Filament
- Seed و Migration کامل جهت راه‌اندازی دیتابیس تستی

---

## 🛠️ تکنولوژی‌های استفاده‌شده

- **Backend:** Laravel 10+, Filament
- **Frontend:** TailwindCSS, Alpine.js, Livewire
- **Auth:** Laravel OTP via SMS
- **Database:** MySQL / SQLite
- **Others:** LocalStorage (for cart), Laravel Seeder

---

## ⚙️ نصب و اجرا

1. پروژه را کلون کنید:
   ```bash
   git clone https://github.com/rezalaal/menu.git
   cd menu
   ```

2. وابستگی‌ها را نصب کنید:
   ```bash
   composer install
   npm install
   ```

3. فایل `.env` بسازید و تنظیمات را انجام دهید:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. دیتابیس را آماده و seed کنید:
   ```bash
   php artisan migrate --seed
   ```

5. محیط توسعه را اجرا کنید:
   ```bash
   npm run dev
   php artisan serve
   ```

---

## 🧪 محدودیت‌ها و هشدار مهم

- این پروژه فاقد سیستم پرداخت، امنیت بالا و لاگ‌گیری پیشرفته است.
- استفاده از LocalStorage برای نگهداری سبد خرید فقط در محیط تست مناسب است.
- ارسال پیامک نیازمند تنظیمات دقیق و سرویس‌دهنده معتبر است.
- هیچ تست خودکاری (unit/integration test) پیاده‌سازی نشده است.

> ⚠️ **تأکید می‌شود که این پروژه نباید در محیط production یا پروژه‌های واقعی بدون بازنویسی دقیق و بررسی امنیتی استفاده شود.**

---

## 📝 لایسنس

انتشار تحت لایسنس [MIT](LICENSE) انجام شده است. استفاده آزاد است، اما مسئولیت استفاده در محیط واقعی بر عهده کاربر است.

---

## 📬 پشتیبانی و سوالات

اگر درباره کد پروژه یا ساختار آن سوالی دارید، خوشحال می‌شوم پاسخگو باشم. کافی‌ست issue باز کنید یا پیام بفرستید.

---

## 🙏 تشکر

از Laravel، Tailwind، Filament و جامعه‌ی منبع‌باز برای فراهم آوردن چنین ابزارهای ارزشمندی سپاسگزاریم.
