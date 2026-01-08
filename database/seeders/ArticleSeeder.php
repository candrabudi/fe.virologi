<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Categories
        $categories = [
            ['name' => 'Research', 'slug' => 'research'],
            ['name' => 'Technology', 'slug' => 'technology'],
            ['name' => 'Policy', 'slug' => 'policy'],
            ['name' => 'Science', 'slug' => 'science'],
            ['name' => 'Health', 'slug' => 'health'],
        ];

        foreach ($categories as $cat) {
            ArticleCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 2. Create Tags
        $tags = [
            ['name' => 'AI', 'slug' => 'ai'],
            ['name' => 'Cybersecurity', 'slug' => 'cybersecurity'],
            ['name' => 'Pathogen', 'slug' => 'pathogen'],
            ['name' => 'Bioinformatics', 'slug' => 'bioinformatics'],
            ['name' => 'Vaccine', 'slug' => 'vaccine'],
        ];

        foreach ($tags as $tag) {
            ArticleTag::updateOrCreate(['slug' => $tag['slug']], $tag);
        }

        // 3. Create Articles
        $articles = [
            [
                'title' => 'Emerging Pathogens: What We Need to Know in 2026',
                'excerpt' => 'An in-depth analysis of the latest viral threats and the global response strategies implemented by leading health organizations.',
                'content' => '<p class="mb-6">The landscape of viral threats is constantly evolving. In 2026, we are facing a new wave of emerging pathogens that require immediate attention and coordinated global response.</p>
                              <p class="mb-6">Recent studies indicate that climate change is playing a significant role in the migration of vectors, bringing tropical diseases to previously unaffected regions. This shift necessitates a re-evaluation of our current surveillance and control strategies.</p>
                              <h3 class="text-2xl font-bold text-slate-900 mt-8 mb-4 heading-font">The Role of Genomic Surveillance</h3>
                              <p class="mb-6">Advanced genomic sequencing has become our primary tool in identifying and tracking these new variants. By analyzing the genetic makeup of these pathogens, we can predict their behavior and potential resistance to existing treatments.</p>
                              <p class="mb-6">Global health organizations are now prioritizing the establishment of a unified data-sharing platform. This initiative aims to reduce the time between detection and response, potentially saving thousands of lives.</p>
                              <h3 class="text-2xl font-bold text-slate-900 mt-8 mb-4 heading-font">Future Recommendations</h3>
                              <p>It is imperative that governments invest in robust public health infrastructure. Strengthening our diagnostic capabilities and ensuring equitable access to medical countermeasures are critical steps in safeguarding global health security.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?auto=format&fit=crop&q=80&w=800',
                'categories' => ['research', 'science'],
                'tags' => ['pathogen', 'bioinformatics'],
            ],
            [
                'title' => 'The Role of AI in Viral Genome Sequencing',
                'excerpt' => 'How artificial intelligence is revolutionizing the speed and accuracy of pathogen identification and vaccine development.',
                'content' => '<p class="mb-6">Artificial Intelligence is transforming the field of virology. By leveraging machine learning algorithms, researchers can now process vast amounts of genomic data in a fraction of the time it previously took.</p>
                              <p class="mb-6">One of the most promising applications of AI is in the prediction of viral evolution. By modeling potential mutation patterns, we can develop vaccines that are more resilient to future variants.</p>
                              <h3 class="text-2xl font-bold text-slate-900 mt-8 mb-4 heading-font">Accelerating Vaccine Development</h3>
                              <p class="mb-6">AI-driven platforms are being used to identify optimal antigen targets, significantly shortening the pre-clinical phase of vaccine development. This speed is crucial when dealing with rapidly spreading outbreaks.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&q=80&w=800',
                'categories' => ['technology', 'research'],
                'tags' => ['ai', 'bioinformatics'],
            ],
            [
                'title' => 'Cybersecurity in High-Consequence Research Labs',
                'excerpt' => 'Protecting critical biological data from digital threats is now as important as physical biosafety protocols.',
                'content' => '<p class="mb-6">As research laboratories become increasingly digitized, they also become more vulnerable to cyber attacks. Ransomware and data theft pose significant risks to the integrity of sensitive pathogen research.</p>
                              <p class="mb-6">Implementing robust cybersecurity frameworks is no longer optional. It is a fundamental component of modern biosafety and biosecurity protocols.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=800',
                'categories' => ['technology', 'policy'],
                'tags' => ['cybersecurity', 'ai'],
            ],
        ];

        foreach ($articles as $data) {
            $categories = $data['categories'];
            $tags = $data['tags'];
            unset($data['categories'], $data['tags']);

            $data['slug'] = Str::slug($data['title']);
            $data['is_published'] = true;
            $data['published_at'] = now();
            
            // SEO Meta placeholders
            $data['seo_title'] = $data['title'];
            $data['seo_description'] = $data['excerpt'];
            $data['og_title'] = $data['title'];
            $data['og_description'] = $data['excerpt'];
            $data['og_image'] = $data['thumbnail'];

            $article = Article::updateOrCreate(['slug' => $data['slug']], $data);

            // Sync Categories
            $categoryIds = ArticleCategory::whereIn('slug', $categories)->pluck('id');
            $article->categories()->sync($categoryIds);

            // Sync Tags
            $tagIds = ArticleTag::whereIn('slug', $tags)->pluck('id');
            $article->tags()->sync($tagIds);
        }
    }
}
