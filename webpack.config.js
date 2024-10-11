const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
module.exports = {
    ...defaultConfig,
    entry: {
        'block': './src/block.js',
        'editor': './src/editor.scss',
        'frontend': './src/frontend.scss'
    },
    output: {
        path: __dirname + '/build/',
        filename: '[name].js'
    }
};
