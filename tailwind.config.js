let plugin = require('tailwindcss/plugin')

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        fontFamily: {
            'exo': ['"Exo 2"', 'ui-sans-serif', 'system-ui', ]
        },
        extend: {
            backgroundImage: {
                'aaf-background': "url('/images/aaf/background.jpg')",
                'aaf-background-2x': "url('/images/aaf/background_2x.jpg')",
                'scarlet-background': "url('/images/home_bg.png')",
                'scarlet-background-2x': "url('/images/home_bg_2x.png')",
            }
        },
    },
    plugins: [
        require("@tailwindcss/forms")({
            strategy: 'base', // only generate global styles
            // strategy: 'class', // only generate classes
        }),
        plugin(function ({ addVariant }) {
            // Add a `third` variant, ie. `third:pb-0`
            addVariant('retina', '@media (-webkit-min-device-pixel-ratio: 2),(min-resolution: 192dpi)')
        })
    ],
}
