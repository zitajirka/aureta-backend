
const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const AssetsPlugin = require('assets-webpack-plugin');
const PurifyCSSPlugin = require('purifycss-webpack');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');

const PRODUCTION = process.env.NODE_ENV === 'production';

module.exports = {


	entry: {

		main: 'main.js',
		vendor: [
			'jquery',
			'bootstrap/js/src/modal',
			'bootstrap/js/src/button',
			'bootstrap/js/src/collapse',
			'bootstrap/js/src/alert',
			'bootstrap/js/src/dropdown',
			'nette.ajax.js',
		],
		commons: [
			'topfix.js'
		]


	},

	output: {
		path: path.resolve(__dirname, PRODUCTION ? './www/scripts/dist' : './www/scripts/dev'),
		publicPath: PRODUCTION ? '/scripts/dist/' : '/scripts/dev/',
		filename: PRODUCTION ? '[chunkhash:10].[name].js' : '[name].js'
	},

	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /(node_modules)/,
				use: 'babel-loader?presets[]=es2015',
			},
			{
				test: /\.s?css$/,
				use: ExtractTextPlugin.extract({
					fallback: 'style-loader',
					use: ['css-loader?minimize', 'sass-loader']
				})
			},
			{
				test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
				use: "url-loader?limit=10000&mimetype=application/font-woff&name=" + (PRODUCTION ? "../../fonts/dist/[hash].[ext]" : "../../fonts/dev/[name].[ext]")
			},
			{
				test: /\.(ttf|eot|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
				use: "file-loader?name=" + (PRODUCTION ? "../../fonts/dist/[hash].[ext]" : "../../fonts/dev/[name].[ext]")
			},
			{
				test: /\.(jpe?g|gif|png)$/,
				loader: "file-loader?emitFile=false&name=" + (PRODUCTION ? "../../images/dist/[hash].[ext]" : "../../images/dev/[name].[ext]")
			}
		]
	},
	resolve: {
		modules: [
			path.resolve('./www/scripts/src'),
			path.resolve('./www/styles/src'),
			path.resolve('./node_modules'),
		],
		alias: {
			'jquery-ui': 'jquery-ui/ui'
		}
	},
	plugins: [
		// vypustí css styly, které nejsou nikde použity
		new PurifyCSSPlugin({
			// Give paths to parse for rules. These should be absolute!
			paths: [
				path.resolve(__dirname, './app/*.latte')
			]
		}),
		// vytvoří externí zkompilovaný css soubor
		new ExtractTextPlugin({
			filename:  PRODUCTION ? '../../styles/dist/[chunkhash:10].[name].css' : '../../styles/dev/[name].css',
			allChunks: true
		}),
		// vytvoří json soubor s aktuálními názvy zkompilovaných souborů
		new AssetsPlugin({
			filename: './app/components/HtmlAssets/assets.json'
		}),
		// do globalu přidá jQuery
		new webpack.ProvidePlugin({
			Nette: path.resolve(__dirname, './vendor/nette/forms/src/assets/netteForms.js'),
			'window.Nette': path.resolve(__dirname, './vendor/nette/forms/src/assets/netteForms.js'),
			'window.jQuery': 'jquery',
			$: 'jquery',
			jQuery: 'jquery',
		}),
		// rozdělí vendor knihovny do zvláštních souborů
		new webpack.optimize.CommonsChunkPlugin({
			names: [
				'commons',
				'vendor',
				'manifest'
			]
		}),
		new UglifyJSPlugin({
			beautify: ! PRODUCTION,
			mangle: PRODUCTION,
			compress: PRODUCTION,
		})


	]
};