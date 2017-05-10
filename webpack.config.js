var webpack = require('webpack');

var production = process.env.NODE_ENV === 'production';

module.exports = {
    entry: {
        index: './src/Bundle/Resources/public/src/js/index.js'
    },
    output: {
        path: './src/Bundle/Resources/public/builds',
        filename: '[name].js',
        publicPath: production ? '/endroidpredictionio/builds/' : 'http://localhost:8080/builds/'
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                loader: 'babel',
                query: {
                    presets: ['es2015', 'react']
                }
            },
            {
                test: /\.css$/,
                loader: "style!css"
            },
            {
                test:   /\.((eot|ttf|woff|woff2|png|gif|jpe?g|svg)?(\?v=[0-9]\.[0-9]\.[0-9])?)$/i,
                loader: 'url?limit=10000',
            }
        ]
    },
    devServer: {
        hot: true,
        contentBase: './src/Bundle/Resources/public/src/',
        headers: { "Access-Control-Allow-Origin": "*" }
    },
    plugins: production ? [
        new webpack.DefinePlugin({
            'process.env': { NODE_ENV: JSON.stringify("production") }
        }),
        new webpack.optimize.UglifyJsPlugin({
            compress: { warnings: false }
        })
    ] : [],
    devtool: production ? 'cheap-module-source-map' : 'cheap-module-eval-source-map'
};
