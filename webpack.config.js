const webpack = require("webpack"),
			path = require("path"),
			env = require("yargs").argv.env,
			version = require("./package.json").version,
			autoprefixer = require("autoprefixer"),
			MiniCssExtractPlugin = require("mini-css-extract-plugin"),
			OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin"),
			FileManagerPlugin = require("filemanager-webpack-plugin"),
			isProd = env === "production";

const config = {
	mode: env,
	entry: [
		__dirname + "/src/script.js",
		__dirname + "/src/style.scss"
	],
	devtool: "source-map",
	output: {
		path: path.resolve(__dirname, "assets"),
		filename: `script${ isProd ? ".min" : "" }.js`
	},
	module: {
		rules: [
			{
				test: /\.js/,
				loader: "babel-loader",
				exclude: /(node_modules|bower_components)/
			},
			{
				test: /\.js/,
				loader: "eslint-loader",
				exclude: /node_modules/
			},
			{
				test: /(\.scss|\.sass)$/,
				use: [
					{
						loader: MiniCssExtractPlugin.loader
					},
					{
						loader: "css-loader",
						options: {
							sourceMap: true,
						}
					},
					{
						loader: "postcss-loader",
						options: {
							sourceMap: true,
						}
					},
					{
						loader: "sass-loader",
						options: {
							sourceMap: true
						}
					}
				],
			},
			{
      	test: /\.(woff|woff2|ttf|eot)(\?v=\d+\.\d+\.\d+)?$/,
	      loader: 'file-loader',
	      include: [/fonts/],

	      options: {
	        name: '[hash].[ext]',
	        outputPath: 'css/',
	        publicPath: url => 'assets/' + url
	      }
	    },
			{
				test: /\.svg/,
				use: [
					{
						loader: "svg-url-loader"
					}
				]
			}
		]
	},
	resolve: {
		modules: [path.resolve("./node_modules"), path.resolve("./src")],
		extensions: [".json", ".js"]
	},
	plugins: [
		new FileManagerPlugin( isProd ? {
			events: {
				onEnd: {
					delete: [__dirname + "/dist/*", __dirname + "/*.zip"],
					copy: [
						{
							source: __dirname + "/*.php",
							destination: __dirname + "/dist"
						},
						{
							source: __dirname + "/parts/*.php",
							destination: __dirname + "/dist/parts"
						},
						{
							source: __dirname + "/*.css",
							destination: __dirname + "/dist"
						},
						{
							source: __dirname + "/assets",
							destination: __dirname + "/dist/assets"
						},
					],
					archive: [
						{
							source: __dirname + "/dist",
							destination: __dirname + "/larc-theme.zip"
						},
					],
				}
			},
			runTasksInSeries: true,
		} : {
			events: {
				onEnd: {
					copy: [
						{
							source: __dirname + "/assets/*.css",
							destination: __dirname + "/"
						}
					]
				}
			},
		} ),
		new MiniCssExtractPlugin({
			filename: `style.css`,
			chunkFilename: "[id].css"
		})
	],
	optimization: {
		minimize: isProd ? true : false,
		minimizer: [
			new OptimizeCSSAssetsPlugin({
				 cssProcessorPluginOptions: {
	        preset: ['default', {
	        	discardComments: {
	        		removeAll: false
	        	}
	        }],
	      },
			}),
		]
	}
};

module.exports = config;