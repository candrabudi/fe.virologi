@extends('layouts.app')

@section('meta_title', 'Home')
@section('meta_description', 'Advanced Research in Virology, Bioinformatics, and Cybersecurity. Protecting global health and digital infrastructure through AI-driven intelligence.')
@section('meta_keywords', 'biosecurity, pathogen research, cybersecurity ai, viral evolution analysis, bioinformatics indonesia')

@section('content')
    <div x-data="homeData">
        
        <!-- Hero Section Wrapper -->
        <div class="bg-slate-950" style="z-index: -9999">
            @include('pages.home.partials.hero')
        </div>

        <!-- Main Content Wrapper -->
        <div class="relative overflow-hidden bg-slate-50">
            <!-- Home Page Sections -->
            <div class="relative z-10">
                @include('pages.home.partials.ebooks')
                @include('pages.home.partials.products')
                @include('pages.home.partials.services')
                @include('pages.home.partials.threat_map')
                @include('pages.home.partials.enterprise')
                @include('pages.home.partials.blog')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('homeData', () => ({
                loading: true,
                hero: {},
                sections: {},
                ebooks: [],
                articles: [],
                products: [],
                services: [],

                async init() {
                    try {
                        // Using global axios instance
                        const response = await axios.get('/api/home');
                        const data = response.data;

                        if (data) {
                            this.hero = data.hero || {};
                            
                            // Convert sections array to object keyed by section_key for easy access in view
                            this.sections = (data.sections || []).reduce((acc, section) => {
                                acc[section.section_key] = section;
                                return acc;
                            }, {});

                            this.ebooks = data.ebooks || [];
                            this.articles = data.articles || [];
                            this.products = data.products || [];
                            this.services = data.services || [];
                        }
                    } catch (e) {
                        console.error('Failed to load homepage data', e);
                    } finally {
                        this.loading = false;
                        // Refresh AOS to ensure animations trigger correctly after data load
                        setTimeout(() => {
                            if (window.AOS) window.AOS.refresh();
                        }, 100);
                    }
                }
            }));
        });
    </script>

    <!-- Home Page Specific Styles -->
    @include('pages.home.partials.styles')
@endsection
