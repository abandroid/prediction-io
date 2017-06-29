let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('src/Bundle/PredictionIODemoBundle/Resources/public/build/')
    .setPublicPath('/bundles/endroidpredictioniodemo/build')
    .setManifestKeyPrefix('/build')
    .cleanupOutputBeforeBuild()
    .addEntry('index', './src/Bundle/PredictionIODemoBundle/Resources/public/src/js/index.js')
    .autoProvidejQuery()
    .enableReactPreset()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();