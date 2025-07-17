import { defineConfig } from 'vitepress'
import pkg from '../package.json'

// https://vitepress.dev/reference/site-config
export default defineConfig({
    title: "Laravel Stateful Resources",
    description: "A Laravel package for managing state in API resources.",
    srcDir: './pages',
    cleanUrls: true,
    markdown: {
        theme: {
            light: 'github-light',
            dark: 'github-dark'
        }
    },
    themeConfig: {
        // https://vitepress.dev/reference/default-theme-config
        nav: [
            { text: 'Home', link: '/' },
            {
                text: pkg.version,
                items: [
                    {
                        text: 'Changelog',
                        link: 'https://github.com/farbcodegmbh/laravel-stateful-resources/blob/main/CHANGELOG.md'
                    },
                    {
                        text: 'Contributing',
                        link: 'https://github.com/farbcodegmbh/laravel-stateful-resources/blob/main/CONTRIBUTING.md'
                    }
                ]
            }
        ],

        sidebar: [
            {
                text: 'Basics',
                items: [
                    { text: 'Installation', link: '/installation' },
                ]
            },
        ],

        socialLinks: [
            { icon: 'github', link: 'https://github.com/farbcodegmbh/laravel-stateful-resources' },
        ],

        footer: {
            message: 'Released under the MIT License.',
            copyright: 'Copyright © 2025-present //farbcode GmbH'
        },

        search: {
            provider: 'local',
        }
    }
})
