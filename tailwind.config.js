import preset from "./vendor/filament/support/tailwind.config.preset";
import typography from "@tailwindcss/typography";
import forms from "@tailwindcss/forms";
/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
    ],
    theme: {
        extend: {},
    },
    plugins: [typography, forms],
};
