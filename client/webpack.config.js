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
        app: './src/app.js'
    },
    target: 'web',
    output: {
        filename: 'app.js',
        path: path.resolve(__dirname, 'dist/public')
    },
};

module.exports = [scriptConfig];