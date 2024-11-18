import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            colors: {
                primary: "rgb(var(--color-primary) / <alpha-value>)",
                highlight: "rgb(var(--color-highlight) / <alpha-value>)",
                secondary: "rgb(var(--color-secondary) / <alpha-value>)",
                accent: "rgb(var(--color-accent) / <alpha-value>)",
                contentc: "rgb(var(--color-text) / <alpha-value>)",
                bgc: {
                    1: "rgb(var(--color-bg) / <alpha-value>)",
                    2: "rgb(var(--color-bg2) / <alpha-value>)",
                },
                boxc: "rgb(var(--color-box) / <alpha-value>)",
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                // sans: ["Oswald", "sans-serif"],
            },
            fontWeight: {
                ...defaultTheme.fontWeight,
                extrablack: "1000",
            },
            textShadow: {
                "white-lg": "0 10px 15px rgba(255, 255, 255, 0.5)",
            },
            variants: {
                extend: {
                    textShadow: ["hover"],
                },
            },
            plugins: [
                function ({ addUtilities }) {
                    addUtilities(
                        {
                            ".text-shadow": {
                                textShadow: "0 2px 4px rgba(0, 0, 0, 0.1)",
                            },
                            ".text-shadow-white-lg": {
                                textShadow:
                                    "0 10px 15px rgba(255, 255, 255, 0.5)",
                            },
                        },
                        ["responsive", "hover"]
                    );
                },
            ],
        },
    },

    plugins: [forms, require("@tailwindcss/typography")],
};
