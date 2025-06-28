<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'section_name' => 'hero',
                'data' => [
                    'en' => [
                        'title' => 'Welcome to SANAD Studio',
                        'description' => 'We are a leading innovation studio helping startups and enterprises build the future.',
                    ],
                    'ar' => [
                        'title' => 'مرحباً بكم في استوديو سند',
                        'description' => 'نحن استوديو ابتكار رائد يساعد الشركات الناشئة والمؤسسات في بناء المستقبل.',
                    ]
                ],
                'is_active' => true
            ],
            [
                'section_name' => 'corporate_innovation',
                'data' => [
                    'en' => [
                        'title' => 'Corporate Innovation',
                        'description' => 'We help corporations innovate and stay ahead of the competition through strategic partnerships and cutting-edge technology solutions.',
                    ],
                    'ar' => [
                        'title' => 'الابتكار المؤسسي',
                        'description' => 'نساعد الشركات على الابتكار والبقاء في المقدمة من خلال الشراكات الاستراتيجية وحلول التكنولوجيا المتطورة.',
                    ]
                ],
                'is_active' => true
            ],
            [
                'section_name' => 'how_we_work',
                'data' => [
                    'en' => [
                        'title' => 'How We Work',
                        'ideation_market_discovery' => 'We start by understanding market needs and identifying opportunities for innovation.',
                        'co_creation_prototyping' => 'We work closely with our partners to create and prototype innovative solutions.',
                        'funding_acceleration' => 'We provide funding and acceleration support to bring ideas to market.',
                        'scaling_market_expansion' => 'We help scale successful solutions and expand into new markets.',
                        'exits_long_term_success' => 'We support long-term success and strategic exits when appropriate.',
                    ],
                    'ar' => [
                        'title' => 'كيف نعمل',
                        'ideation_market_discovery' => 'نبدأ بفهم احتياجات السوق وتحديد الفرص للابتكار.',
                        'co_creation_prototyping' => 'نعمل بشكل وثيق مع شركائنا لإنشاء ونمذجة الحلول المبتكرة.',
                        'funding_acceleration' => 'نقدم التمويل ودعم التسريع لطرح الأفكار في السوق.',
                        'scaling_market_expansion' => 'نساعد في توسيع الحلول الناجحة والتوسع في أسواق جديدة.',
                        'exits_long_term_success' => 'ندعم النجاح طويل المدى والمخارج الاستراتيجية عند الاقتضاء.',
                    ]
                ],
                'is_active' => true
            ],
            [
                'section_name' => 'partner_with_us',
                'data' => [
                    'en' => [
                        'title' => 'Partner With Us',
                        'description' => 'Join our ecosystem of innovation. Whether you\'re a startup looking for support or a corporation seeking innovation, we\'re here to help you succeed.',
                    ],
                    'ar' => [
                        'title' => 'اشترك معنا',
                        'description' => 'انضم إلى نظامنا البيئي للابتكار. سواء كنت شركة ناشئة تبحث عن الدعم أو شركة تسعى للابتكار، نحن هنا لمساعدتك على النجاح.',
                    ]
                ],
                'is_active' => true
            ]
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['section_name' => $pageData['section_name']],
                $pageData
            );
        }

        $this->command->info('Page content seeded successfully!');
    }
}
