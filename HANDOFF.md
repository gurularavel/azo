# Handoff Notes

Date: 2026-01-14

What is done:
- Laravel scaffolded and app structure in place.
- Core flows: registration + OTP mock, subscriptions, shop list/detail, QR session + verify, usage tracking.
- Admin panel: dashboard, shops CRUD, users, plans CRUD, transactions log.
- Localization: EN/AZ/RU via `resources/lang/*`.
- Media: shop logo/header/gallery uploads with gallery popup on shop detail.

Known issues / checks:
- QR render uses `<canvas>` in `resources/views/shops/show.blade.php`.
- Upload error: added detailed upload logs; uses stream-based storage to avoid empty path bug.

Files touched recently:
- `app/Http/Controllers/Admin/ShopController.php`
- `resources/views/shops/show.blade.php`
- `resources/views/admin/*`
- `routes/web.php`
- `resources/lang/en/messages.php`
- `resources/lang/az/messages.php`
- `resources/lang/ru/messages.php`

Next steps:
1) Run migrations and storage link:
   - `php artisan migrate --seed`
   - `php artisan storage:link`
2) Create a shop in admin and upload images (logo/header/gallery).
3) Login as user, buy a plan, open shop page, confirm QR appears.
4) If QR still missing, verify active subscription + `usage_remaining > 0`.

