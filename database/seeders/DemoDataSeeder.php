<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedBlogs();
        $this->seedServices();
    }

    private function seedBlogs(): void
    {
        $blogs = [
            [
                'title'    => 'QR Endirim Kartı ilə Necə Qənaət Etmək Olar?',
                'excerpt'  => 'Hər mağazada QR kodunuzu skan etdirərək anında endirim əldə edin. Bu yazıda endirim kartından maksimum fayda əldə etmənin yollarını öyrənəcəksiniz.',
                'body'     => '<h2>QR Endirim Kartının Üstünlükləri</h2><p>Müasir həyatda alış-veriş daha ağıllı olmalıdır. QR Endirim kartı sayəsində partnyor mağazalarda avtomatik endirim əldə edirsiniz.</p><h3>Necə İstifadə Etmək Olar?</h3><ol><li>Tətbiqdən QR kod yaradın</li><li>Kassada kassira göstərin</li><li>Anında endiriminizi alın</li></ol><p>Bu qədər sadə! Hər ay yüzlərlə manat qənaət etmək mümkündür.</p>',
                'image'    => 'https://picsum.photos/seed/blog1/800/450',
                'home'     => true,
            ],
            [
                'title'    => 'Ən Çox Endirim Verən 10 Mağaza',
                'excerpt'  => 'Bakının ən məşhur ticarət mərkəzlərindəki partnyor mağazalarımız haqqında məlumat əldə edin.',
                'body'     => '<h2>Ən Yaxşı Tərəfdaş Mağazalar</h2><p>Platformamızdakı 200-dən çox mağaza arasından ən çox endirim verənləri sizin üçün seçdik.</p><p>Bu mağazalarda ortalama <strong>15-30%</strong> endirim əldə edə bilərsiniz.</p><ul><li>Elektronika mağazaları</li><li>Geyim salonları</li><li>Ərzaq supermarketləri</li><li>Restoran və kafelər</li></ul>',
                'image'    => 'https://picsum.photos/seed/blog2/800/450',
                'home'     => true,
            ],
            [
                'title'    => 'Abunəlik Planlarını Müqayisə Edin',
                'excerpt'  => 'Hansı plan sizə daha uyğundur? Aylıq və illik planların müqayisəsini bu yazıda tapacaqsınız.',
                'body'     => '<h2>Hansi Plan Sizin Üçün?</h2><p>Platformamızda 3 fərqli abunəlik planı mövcuddur. Ehtiyaclarınıza uyğun planı seçin.</p><h3>Əsas Plan</h3><p>Ayda 5 dəfə istifadə imkanı. Kiçik alış-veriş edənlər üçün ideal.</p><h3>Standard Plan</h3><p>Ayda 15 dəfə istifadə imkanı. Ən populyar seçim.</p><h3>Premium Plan</h3><p>Limitsiz istifadə. Aktiv alıcılar üçün ən sərfəli variant.</p>',
                'image'    => 'https://picsum.photos/seed/blog3/800/450',
                'home'     => true,
            ],
            [
                'title'    => 'Bakıda Ən Yaxşı Alış-veriş Mərkəzləri',
                'excerpt'  => 'Paytaxtın ən böyük ticarət mərkəzlərində tərəfdaş mağazalarımız sizi gözləyir.',
                'body'     => '<h2>Bakı Ticarət Mərkəzlərindəki Tərəfdaşlarımız</h2><p>Şəhərin hər nöqtəsindəki iri ticarət mərkəzlərində bizimlə əməkdaşlıq edən mağazalar fəaliyyət göstərir.</p><p>Port Baku, Ganjlik Mall, Park Bulvar — bu mərkəzlərin hamısında kartınızdan istifadə edə bilərsiniz.</p>',
                'image'    => 'https://picsum.photos/seed/blog4/800/450',
                'home'     => false,
            ],
            [
                'title'    => 'Uşaq Məhsullarında Qənaət Etməyin 5 Yolu',
                'excerpt'  => 'Valideynlər üçün xüsusi: uşaq mağazalarında endirim kartı ilə necə daha çox qənaət etmək olar.',
                'body'     => '<h2>Uşaq Xərclərinizi Azaldın</h2><p>Uşaq məhsulları baha ola bilər, lakin doğru strategiya ilə xərclərinizi əhəmiyyətli dərəcədə azalda bilərsiniz.</p><p>Partnyor uşaq mağazalarımızda ortalama <strong>20%</strong> endirim əldə edin.</p>',
                'image'    => 'https://picsum.photos/seed/blog5/800/450',
                'home'     => false,
            ],
            [
                'title'    => 'Restoran və Kafelərde Endirim',
                'excerpt'  => 'Sevdiyiniz restoranlarda yemək yerken pul qənaət etmək artıq mümkündür.',
                'body'     => '<h2>Yemək Xərclərini Azaldın</h2><p>Platformamızdakı 50-dən çox restoran və kafedə kartınız ilə endirim əldə edin. Ailə şamları, iş naharları — hamısında qənaət edin.</p>',
                'image'    => 'https://picsum.photos/seed/blog6/800/450',
                'home'     => false,
            ],
            [
                'title'    => 'Yeni İl Alış-verişi Üçün Məsləhətlər',
                'excerpt'  => 'Yeni il hədiyyə alarkən büdcənizi aşmamaq üçün bu ipuclarından yararlanın.',
                'body'     => '<h2>Yeni İl Büdcənizi Planlayın</h2><p>Bayram mövsümündə xərclər artır. QR Endirim kartınızla hədiyyə alış-verişini daha sərfəli edin. Tərəfdaş mağazalarda xüsusi bayram endirimlərindən yararlanın.</p>',
                'image'    => 'https://picsum.photos/seed/blog7/800/450',
                'home'     => false,
            ],
            [
                'title'    => 'Elektronika Alışında Qənaət Haqqında',
                'excerpt'  => 'Telefon, noutbuk, ev texnikası alarkən tərəfdaş mağazalarımızın endirimlərindən faydalanın.',
                'body'     => '<h2>Texnologiyaya Daha Az Xərc</h2><p>Elektronika mağazalarımızda ortalama <strong>10-25%</strong> endirim əldə edin. Böyük məbləğli alışlarda bu qənaət xeyli vacibdir.</p>',
                'image'    => 'https://picsum.photos/seed/blog8/800/450',
                'home'     => false,
            ],
            [
                'title'    => 'Sağlıq və Gözəllik Məhsullarında Endirim',
                'excerpt'  => 'Aptek, gözəllik salonları və fitnes mərkəzlərindəki tərəfdaşlarımız endirim təklif edir.',
                'body'     => '<h2>Sağlıqlı Həyat, Sərfəli Qiymət</h2><p>Sağlıq xərclərini azaltmaq üçün partnyor aptek və klinikalarımızda kartınızdan istifadə edin. Gözəllik salonlarında da endirimlər sizləri gözləyir.</p>',
                'image'    => 'https://picsum.photos/seed/blog9/800/450',
                'home'     => false,
            ],
            [
                'title'    => 'Müştərilərimizin Uğur Hekayələri',
                'excerpt'  => 'Platformamızdan istifadə edən müştərilərimiz öz təcrübələrini paylaşır.',
                'body'     => '<h2>Həqiqi İnsanlar, Həqiqi Qənaət</h2><p>"Bu kart sayəsində aylıq alış-veriş xərclərimi 30% azaltdım." — Aytən, Bakı</p><p>"İş naharlarımda hər gün istifadə edirəm. Çox rahat sistem." — Rauf, Gəncə</p><p>"Ailə üçün ən yaxşı investisiya." — Sevinc, Sumqayıt</p>',
                'image'    => 'https://picsum.photos/seed/blog10/800/450',
                'home'     => false,
            ],
        ];

        foreach ($blogs as $i => $data) {
            $slug = Str::slug($data['title']);
            // Ensure slug uniqueness
            $candidate = $slug;
            $counter = 2;
            while (Blog::where('slug', $candidate)->exists()) {
                $candidate = $slug . '-' . $counter++;
            }

            Blog::create([
                'title'           => $data['title'],
                'slug'            => $candidate,
                'excerpt'         => $data['excerpt'],
                'body'            => $data['body'],
                'cover_image_path'=> $data['image'],
                'is_published'    => true,
                'show_on_home'    => $data['home'],
                'published_at'    => now()->subDays(count($blogs) - $i),
            ]);
        }

        $this->command->info('Blogs seeded: ' . count($blogs));
    }

    private function seedServices(): void
    {
        $services = [
            [
                'title'   => 'QR Kod Endirimi',
                'excerpt' => 'Mağazada tək bir skan ilə endiriminizi anında əldə edin. Sadə, sürətli və etibarlı.',
                'body'    => '<h2>QR Kod Endirimi Necə İşləyir?</h2><p>Tətbiqdən QR kod yaradın, kassada kassirə göstərin — endiriminiz avtomatik tətbiq olunur. Heç bir fiziki kart gerekmez.</p><ul><li>Anında aktivləşmə</li><li>Bütün tərəfdaş mağazalarda keçərli</li><li>Tarixi qeyd olunur</li></ul>',
                'image'   => 'https://picsum.photos/seed/srv1/800/500',
            ],
            [
                'title'   => 'Abunəlik Planları',
                'excerpt' => 'Ehtiyacınıza uyğun planı seçin. Aylıq limitsiz istifadədən tut, standart paketlərə qədər.',
                'body'    => '<h2>Sizin Üçün Uyğun Plan</h2><p>Kiçik büdcədən böyük planlaşdırmaya qədər hər kəs üçün münasib abunəlik variantımız var.</p><p>Planlar avtomatik olaraq hər ay yenilənir və istənilən vaxt ləğv edilə bilər.</p>',
                'image'   => 'https://picsum.photos/seed/srv2/800/500',
            ],
            [
                'title'   => 'Tərəfdaş Mağazalar Şəbəkəsi',
                'excerpt' => 'Azərbaycanın hər yerindəki 200+ tərəfdaş mağazada endirimlərdən yararlanın.',
                'body'    => '<h2>Geniş Tərəfdaş Şəbəkəsi</h2><p>Ərzaqdan elektronikaya, geyimdən restorana — hər sahədə tərəfdaşımız var. Şəhərin hər nöqtəsindəki mağazalarda kartınız qüvvədədir.</p>',
                'image'   => 'https://picsum.photos/seed/srv3/800/500',
            ],
            [
                'title'   => 'Cashback & Bonus Sistemi',
                'excerpt' => 'Hər alış-verişdə bonus qazanın. Toplanmış bonuslarınızı növbəti alışda istifadə edin.',
                'body'    => '<h2>Bonus Sistemi ilə Daha Çox Qənaət</h2><p>Sadə endirimlərlə yanaşı, hər alışdan cashback bonusu qazanırsınız. Bu bonuslar hesabınızda birikirir və növbəti alışınızda istifadə edilə bilər.</p>',
                'image'   => 'https://picsum.photos/seed/srv4/800/500',
            ],
            [
                'title'   => 'Korporativ Həllər',
                'excerpt' => 'Şirkətinizin işçiləri üçün toplu abunəlik. Korporativ müştərilərə xüsusi endirimlər.',
                'body'    => '<h2>Biznesiniz Üçün Xüsusi Həllər</h2><p>10 nəfərdən çox işçisi olan şirkətlər üçün korporativ paketlər hazırladıq. İşçi məmnuniyyətini artırın, xərclərini azaldın.</p><p>Korporativ müqavilə üçün bizimlə əlaqə saxlayın.</p>',
                'image'   => 'https://picsum.photos/seed/srv5/800/500',
            ],
            [
                'title'   => '7/24 Müştəri Dəstəyi',
                'excerpt' => 'Suallarınız, problemləriniz? Komandamız həftənin 7 günü, sutkanın 24 saatı sizin üçün hazırdır.',
                'body'    => '<h2>Həmişə Yanınızdayıq</h2><p>Texniki yardım, hesab məsələləri, mağaza önerileri — hər mövzuda dəstək komandamız sizinlədir.</p><ul><li>Canlı chat</li><li>Email dəstəyi</li><li>Telefon yardım xətti</li></ul>',
                'image'   => 'https://picsum.photos/seed/srv6/800/500',
            ],
        ];

        foreach ($services as $i => $data) {
            $slug = Str::slug($data['title']);
            $candidate = $slug;
            $counter = 2;
            while (Service::where('slug', $candidate)->exists()) {
                $candidate = $slug . '-' . $counter++;
            }

            Service::create([
                'title'        => $data['title'],
                'slug'         => $candidate,
                'excerpt'      => $data['excerpt'],
                'body'         => $data['body'],
                'image_path'   => $data['image'],
                'is_published' => true,
                'show_on_home' => true,
                'published_at' => now()->subDays(count($services) - $i),
            ]);
        }

        $this->command->info('Services seeded: ' . count($services));
    }
}
