<!DOCTYPE html>
<html lang="az">
<head><meta charset="utf-8"><title>Yeni Abunəçi</title></head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; margin: 0;">
<div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08);">
    <div style="background: #213b67; padding: 30px 40px;">
        <h1 style="color: #fff; margin: 0; font-size: 22px;">🎉 Yeni Abunəçi</h1>
    </div>
    <div style="padding: 36px 40px;">
        <p style="font-size: 16px; color: #444; line-height: 1.6;">
            Saytınıza yeni bir abunəçi qoşuldu:
        </p>
        <div style="background: #f0f4ff; border-left: 4px solid #213b67; padding: 16px 20px; border-radius: 6px; margin: 20px 0;">
            <span style="font-size: 18px; font-weight: bold; color: #213b67;">{{ $subscriber->email }}</span>
        </div>
        <p style="color: #888; font-size: 13px;">Tarix: {{ $subscriber->created_at->format('d.m.Y H:i') }}</p>
        <div style="margin-top: 24px;">
            <a href="{{ url('/admin/subscribers') }}"
               style="display: inline-block; background: #213b67; color: #fff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                Abunəçiləri Görüntülə
            </a>
        </div>
    </div>
    <div style="background: #f8f9fa; padding: 18px 40px; font-size: 12px; color: #aaa; text-align: center;">
        Bu bildiriş avtomatik olaraq göndərilmişdir.
    </div>
</div>
</body>
</html>
