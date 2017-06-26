let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('src/Bundle/Resources/public/build/')
    .setPublicPath('/bundles/endroidpredictionio/build')
    .setManifestKeyPrefix('/build')
    .cleanupOutputBeforeBuild()
    .addEntry('index', './src/Bundle/Resources/public/src/js/index.js')
    .autoProvidejQuery()
    .enableReactPreset()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();