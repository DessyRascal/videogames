module.exports = {
    plugins: [
        require('tailwindcss'),
        require('autoprefixer'),
        require('@fullhuman/postcss-purgecss')({
            content: [
                './templates/**/*.html.twig'
            ],
            defaultExtractor: content => content.match(/[A-Za-z0-9-_:/]+/g) || []
        })
    ]
};
