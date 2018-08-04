let webpack = require('webpack');
let path = require('path');
let fs = require('fs');

let nodeModules = {};
fs.readdirSync('node_modules')
    .filter(function (x) {
        return ['.bin'].indexOf(x) === -1;
    })
    .forEach(function (mod) {
        nodeModules[mod] = 'commonjs ' + mod;
    });

const scriptConfig = {
    name: 'app',
    entry: {
        app: './src/assets/app.js'
    },
    target: 'web',
    output: {
        filename: 'app.js',
        path: path.resolve(__dirname, 'dist/public')
    },
};

const appConfig = {
    name: 'index',
    entry: {
        index: './src/index.ts',
    },
    target: 'node',
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, 'dist')
    },
    devtool: 'source-map',
    resolve: {
        // Add `.ts` and `.tsx` as a resolvable extension.
        extensions: ['.ts', '.tsx', '.js']
    },
    module: {
        rules: [
            // all files with a `.ts` or `.tsx` extension will be handled by `ts-loader`
            {test: /\.tsx?$/, loader: 'ts-loader'}
        ]
    },
    externals: nodeModules,
    node: {
        __filename: true,
        __dirname: true
    }
};

module.exports = [scriptConfig, appConfig];
