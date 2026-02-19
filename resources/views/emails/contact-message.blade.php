<!DOCTYPE html>
<html lang="az">
<head><meta charset="utf-8"><title>Yeni Əlaqə Mesajı</title></head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; margin: 0;">
<div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08);">
    <div style="background: #213b67; padding: 30px 40px;">
        <h1 style="color: #fff; margin: 0; font-size: 22px;">📨 Yeni Əlaqə Mesajı</h1>
    </div>
    <div style="padding: 36px 40px;">
        <table style="width:100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px 0; color: #888; width: 130px; font-size: 14px;">Ad:</td>
                <td style="padding: 10px 0; font-weight: bold; color: #1a1a2e;">{{ $contactMessage->name }}</td>
            </tr>
            <tr style="border-top: 1px solid #f0f0f0;">
                <td style="padding: 10px 0; color: #888; font-size: 14px;">E-mail:</td>
                <td style="padding: 10px 0; color: #1a1a2e;"><a href="mailto:{{ $contactMessage->email }}" style="color: #213b67;">{{ $contactMessage->email }}</a></td>
            </tr>
            @if($contactMessage->phone)
            <tr style="border-top: 1px solid #f0f0f0;">
                <td style="padding: 10px 0; color: #888; font-size: 14px;">Telefon:</td>
                <td style="padding: 10px 0; color: #1a1a2e;">{{ $contactMessage->phone }}</td>
            </tr>
            @endif
            <tr style="border-top: 1px solid #f0f0f0;">
                <td style="padding: 10px 0; color: #888; font-size: 14px; vertical-align: top;">Mesaj:</td>
                <td style="padding: 10px 0; color: #1a1a2e; line-height: 1.7;">{{ $contactMessage->message }}</td>
            </tr>
            <tr style="border-top: 1px solid #f0f0f0;">
                <td style="padding: 10px 0; color: #888; font-size: 14px;">Tarix:</td>
                <td style="padding: 10px 0; color: #888; font-size: 13px;">{{ $contactMessage->created_at->format('d.m.Y H:i') }}</td>
            </tr>
        </table>

        <div style="margin-top: 28px;">
            <a href="{{ url('/admin/contact-messages') }}"
               style="display: inline-block; background: #213b67; color: #fff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                Admin Paneldə Bax
            </a>
        </div>
    </div>
    <div style="background: #f8f9fa; padding: 18px 40px; font-size: 12px; color: #aaa; text-align: center;">
        Bu bildiriş avtomatik olaraq göndərilmişdir.
    </div>
</div>
</body>
</html>
