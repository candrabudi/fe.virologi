import axios from './axios';

/**
 * Homepage API Service
 */
export const homeApi = {
    /**
     * Get all homepage data
     */
    getAll() {
        return axios.get('/api/home');
    },

    /**
     * Get hero section
     */
    getHero() {
        return axios.get('/api/home/hero');
    },

    /**
     * Get all sections
     */
    getSections() {
        return axios.get('/api/home/sections');
    },

    /**
     * Get specific section by key
     */
    getSection(key) {
        return axios.get(`/api/home/section/${key}`);
    },

    /**
     * Get ebooks
     */
    getEbooks() {
        return axios.get('/api/home/ebooks');
    }
};

/**
 * Initialize homepage with dynamic data
 */
export async function initHomepage() {
    try {
        const { data } = await homeApi.getAll();

        return {
            hero: data.hero,
            sections: data.sections,
            ebooks: data.ebooks,
        };
    } catch (error) {
        console.error('Error loading homepage data:', error);
        return null;
    }
}
