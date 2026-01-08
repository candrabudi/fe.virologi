<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ebook;
use Illuminate\Support\Str;

class EbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ebooks = [
            [
                'title' => 'AI Neural Security Map 2026',
                'subtitle' => 'Building Resilient Frameworks for Future Pathogens',
                'summary' => 'Comprehensive guide to AI-driven biosecurity and viral threat detection.',
                'level' => 'advanced',
                'topic' => 'application_security',
                'author' => 'Dr. Aris Setiawan',
                'cover_image' => 'https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?auto=format&fit=crop&q=80&w=600',
                'page_count' => 120,
                'published_at' => '2026-01-01',
                'is_active' => true,
                'sort_order' => 1,
                'learning_objectives' => [
                    'Understanding neural networks in pathogen detection',
                    'Implementing secure AI pipelines',
                    'Strategic defense against synthetic threats'
                ],
                'chapters' => [
                    ['title' => 'Introduction to Neural Security', 'pages' => '1-15'],
                    ['title' => 'Data Integrity in Virology', 'pages' => '16-45'],
                    ['title' => 'Case Studies: 2025 Outbreaks', 'pages' => '46-90']
                ],
                'ai_keywords' => ['neural', 'virology', 'defense', 'cybersecurity']
            ],
            [
                'title' => 'Zero Trust Architecture in Lab Environments',
                'subtitle' => 'Securing High-Risk Research Data',
                'summary' => 'Implementing zero trust protocols for laboratory information systems.',
                'level' => 'intermediate',
                'topic' => 'network_security',
                'author' => 'Research Team RD-VIROLOGI',
                'cover_image' => 'https://images.unsplash.com/photo-1639762681485-074b7f938ba0?auto=format&fit=crop&q=80&w=600',
                'page_count' => 85,
                'published_at' => '2025-12-15',
                'is_active' => true,
                'sort_order' => 2,
                'learning_objectives' => [
                    'Zero Trust core principles',
                    'Network segmentation for labs',
                    'Identity management in research'
                ],
                'chapters' => [
                    ['title' => 'The Zero Trust Mandate', 'pages' => '1-20'],
                    ['title' => 'Identity as the Perimeter', 'pages' => '21-50'],
                ],
                'ai_keywords' => ['zero-trust', 'network', 'lab-security']
            ],
            [
                'title' => 'Foundations of Bioinformatics Security',
                'subtitle' => 'A Beginner\'s Guide',
                'summary' => 'Starting your journey in securing biological data sequences.',
                'level' => 'beginner',
                'topic' => 'general',
                'author' => 'Jane Smith',
                'cover_image' => 'https://images.unsplash.com/photo-1576086213369-97a306d36557?auto=format&fit=crop&q=80&w=600',
                'page_count' => 45,
                'published_at' => '2025-11-20',
                'is_active' => true,
                'sort_order' => 3,
                'learning_objectives' => [
                    'Basic terms in bioinformatics',
                    'Data encryption for DNA sequences',
                    'Safe database management'
                ],
                'chapters' => [
                    ['title' => 'What is Bioinformatics?', 'pages' => '1-10'],
                    ['title' => 'Basic Encryption', 'pages' => '11-30'],
                ],
                'ai_keywords' => ['bioinformatics', 'security', 'beginner']
            ]
        ];

        foreach ($ebooks as $data) {
            $data['uuid'] = (string) Str::uuid();
            $data['slug'] = Str::slug($data['title']);
            $data['file_path'] = 'ebooks/manual.pdf'; // Placeholder
            $data['meta_title'] = $data['title'];
            $data['meta_description'] = $data['summary'] ?? $data['subtitle'];
            $data['meta_keywords'] = $data['ai_keywords'];
            
            Ebook::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
