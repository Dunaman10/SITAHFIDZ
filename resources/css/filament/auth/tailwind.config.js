import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Auth/**/*.php',
        './resources/views/filament/auth/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
