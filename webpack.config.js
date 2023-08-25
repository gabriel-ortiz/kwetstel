const path = require("path");
const glob = require("glob");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

/**
 * @see https://javascript.plainenglish.io/webpack-in-2021-typescript-jest-sass-eslint-7b4640842e27
 *
 * @type {import('webpack').Configuration}
 */
module.exports = {
	mode: "development",
	entry: {
		scripts: glob.sync("./assets/scripts/js/components/**/*.js"),
		"layout-blocks": glob.sync("./assets/scripts/js/layout-blocks/**/*.js"),
		styles: "./assets/styles/scss/style.scss",
		"vendor-styles": "./assets/styles/scss/vendor.scss",
		// "gutenberg-styles": './assets/styles/scss/gutenberg-styles.scss'
	},
	devtool: "source-map",
	ignoreWarnings: [
		{
			module: /node_modules/,
		},
	],
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/,
				exclude: /node_modules/,
				use: ["babel-loader"],
			},
			{
				test: /\.(s(a|c)ss)$/,
				exclude: /node_modules/,
				use: [
					{
						loader: MiniCssExtractPlugin.loader,
						options: {
							publicPath: "./assets/images/src/",
						},
					},
					"css-loader",
					{
						loader: "resolve-url-loader",
					},
					{
						loader: "sass-loader",
						options: {
							sourceMap: true, // <-- !!IMPORTANT!!
						},
					},
				],
			},
		],
	},
	resolve: {
		extensions: ["*", ".js", ".jsx"],
	},
	plugins: [new MiniCssExtractPlugin()],
	output: {
		path: path.resolve(__dirname, "./public"),
	},
};
