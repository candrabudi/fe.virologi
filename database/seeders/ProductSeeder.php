<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'AI Threat Detection System',
                'subtitle' => 'Real-time AI-powered threat intelligence platform',
                'summary' => 'Advanced machine learning system for detecting and analyzing cyber threats in real-time across your entire network infrastructure.',
                'content' => '<p>Our AI Threat Detection System leverages cutting-edge machine learning algorithms to identify and neutralize threats before they can cause damage. The system continuously monitors network traffic, analyzes patterns, and provides actionable intelligence to your security team.</p>',
                'product_type' => 'digital',
                'ai_domain' => 'network_security',
                'ai_level' => 'advanced',
                'ai_keywords' => ['threat detection', 'AI security', 'network monitoring', 'machine learning', 'cybersecurity'],
                'ai_intents' => ['protect network', 'detect threats', 'security monitoring'],
                'ai_use_cases' => ['Enterprise network protection', 'Real-time threat analysis', 'Automated incident response'],
                'ai_priority' => 10,
                'is_ai_visible' => true,
                'is_ai_recommended' => true,
                'cta_label' => 'Request Demo',
                'cta_url' => 'https://wa.me/6281234567890',
                'cta_type' => 'whatsapp',
                'thumbnail' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&q=80&w=600',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Penetration Testing Suite',
                'subtitle' => 'Comprehensive security assessment toolkit',
                'summary' => 'Professional-grade penetration testing tools designed for security professionals to identify vulnerabilities before attackers do.',
                'content' => '<p>Our Penetration Testing Suite provides a complete set of tools for ethical hackers and security professionals. Test your systems, identify weaknesses, and strengthen your defenses with industry-leading penetration testing capabilities.</p>',
                'product_type' => 'digital',
                'ai_domain' => 'pentest',
                'ai_level' => 'intermediate',
                'ai_keywords' => ['penetration testing', 'security assessment', 'vulnerability scanning', 'ethical hacking'],
                'ai_intents' => ['test security', 'find vulnerabilities', 'security audit'],
                'ai_use_cases' => ['Security auditing', 'Compliance testing', 'Vulnerability assessment'],
                'ai_priority' => 8,
                'is_ai_visible' => true,
                'is_ai_recommended' => true,
                'cta_label' => 'Get Started',
                'cta_url' => '/contact',
                'cta_type' => 'internal',
                'thumbnail' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&q=80&w=600',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Cloud Security Platform',
                'subtitle' => 'Multi-cloud security management solution',
                'summary' => 'Unified security platform for managing and protecting your cloud infrastructure across AWS, Azure, and Google Cloud.',
                'content' => '<p>Secure your cloud infrastructure with our comprehensive Cloud Security Platform. Monitor compliance, detect misconfigurations, and protect your data across multiple cloud providers from a single dashboard.</p>',
                'product_type' => 'service',
                'ai_domain' => 'cloud_security',
                'ai_level' => 'all',
                'ai_keywords' => ['cloud security', 'multi-cloud', 'compliance', 'cloud monitoring'],
                'ai_intents' => ['secure cloud', 'cloud compliance', 'cloud monitoring'],
                'ai_use_cases' => ['Cloud infrastructure protection', 'Compliance management', 'Security posture management'],
                'ai_priority' => 9,
                'is_ai_visible' => true,
                'is_ai_recommended' => true,
                'cta_label' => 'Schedule Consultation',
                'cta_url' => 'https://wa.me/6281234567890',
                'cta_type' => 'whatsapp',
                'thumbnail' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=600',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'SOC Automation Bundle',
                'subtitle' => 'Complete Security Operations Center automation',
                'summary' => 'Streamline your SOC operations with automated threat detection, incident response, and comprehensive security analytics.',
                'content' => '<p>Transform your Security Operations Center with our automation bundle. Reduce response times, improve threat detection accuracy, and empower your security team with intelligent automation tools.</p>',
                'product_type' => 'bundle',
                'ai_domain' => 'soc',
                'ai_level' => 'advanced',
                'ai_keywords' => ['SOC automation', 'security operations', 'incident response', 'SIEM'],
                'ai_intents' => ['automate SOC', 'improve security operations', 'incident management'],
                'ai_use_cases' => ['SOC automation', 'Threat hunting', 'Incident orchestration'],
                'ai_priority' => 7,
                'is_ai_visible' => true,
                'is_ai_recommended' => false,
                'cta_label' => 'Learn More',
                'cta_url' => '/contact',
                'cta_type' => 'form',
                'thumbnail' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=600',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($products as $productData) {
            $productData['slug'] = Str::slug($productData['name']);
            $productData['seo_title'] = $productData['name'] . ' | RD-VIROLOGI';
            $productData['seo_description'] = $productData['summary'];
            $productData['seo_keywords'] = $productData['ai_keywords'];
            
            $product = Product::updateOrCreate(
                ['slug' => $productData['slug']],
                $productData
            );

            // Add primary image
            ProductImage::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'is_primary' => true
                ],
                [
                    'image_path' => $productData['thumbnail'],
                    'alt_text' => $product->name,
                    'sort_order' => 0,
                ]
            );
        }
    }
}
