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
                    { text: 'Basic Usage', link: '/basic-usage' },
                ]
            },
            {
                text: 'Advanced Usage',
                items: [
                    { text: 'Extending States', link: '/extending-states' }
                ]
            }
        ],

        socialLinks: [
            { icon: 'github', link: 'https://github.com/farbcodegmbh/laravel-stateful-resources' },
            {
                icon: {
                    svg: '<svg width="100%" height="100%" viewBox="0 0 215 215" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"><rect id="Artboard1" x="0" y="0" width="215" height="215" style="fill:none;"/><g><g><path d="M164.136,6.857L211.041,6.857L122.651,207.615L75.746,207.615L164.136,6.857Z" style="fill:#003e99;fill-rule:nonzero;"/><path d="M93.089,6.857L140.027,6.857L51.637,207.615L4.732,207.615L93.089,6.857Z" style="fill:#0bbaee;fill-rule:nonzero;"/></g></g></svg>'
                },
                link: 'https://farbcode.net'
            },
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
