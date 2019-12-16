import path from 'path'
import webpack from 'webpack'
import Fiber from 'fibers'
import Sass from 'sass'
import { VueLoaderPlugin } from 'vue-loader'
import SvgStore from 'webpack-svgstore-plugin'
import CopyWebpackPlugin from 'copy-webpack-plugin'
import HtmlWebpackPlugin from 'html-webpack-plugin'
import ManifestPlugin from 'webpack-manifest-plugin'
import TerserPlugin from 'terser-webpack-plugin'
import ImageminWebpackPlugin from 'imagemin-webpack-plugin'
import MiniCssExtractPlugin from 'mini-css-extract-plugin'
import OptimizeCssAssetsPlugin from 'optimize-css-assets-webpack-plugin'
import { ifDev, ifProd, removeEmpty } from './utilities'
import { rootPath, srcPath, buildPath } from './paths'

export default {

  mode: ifDev('development', 'production'),

  entry: {
    app: removeEmpty([
      ifDev('webpack-hot-middleware/client?reload=true'),
      `${srcPath}/assets/sass/main.scss`,
      `${srcPath}/assets/js/main.js`,
    ]),
  },

  output: {
    path: `${buildPath}/`,
    filename: 'assets/js/[name].[hash].js',
    chunkFilename: 'assets/js/[name].[chunkhash].js',
    publicPath: '/',
  },

  resolve: {
    extensions: ['.js', '.scss', '.vue'],
    alias: {
      vue$: 'vue/dist/vue.esm.js',
      modernizr: path.resolve(rootPath, '../.modernizr'),
      modules: path.resolve(rootPath, '../node_modules'),
      images: `${srcPath}/assets/images`,
      fonts: `${srcPath}/assets/fonts`,
      settings: `${srcPath}/assets/sass/1-settings/index`,
      utilityFunctions: `${srcPath}/assets/sass/2-utility-functions/index`,
    },
    modules: [
      `${srcPath}/assets/js`,
      `${srcPath}/assets/js/Components`,
      path.resolve(rootPath, '../node_modules'),
    ],
  },

  devtool: ifDev('eval-source-map', 'source-map'),

  module: {
    rules: [
      {
        test: /\.modernizr$/,
        loader: 'modernizr-loader',
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader',
      },
      {
        test: /\.js$/,
        loader: ifDev('babel-loader?cacheDirectory=true', 'babel-loader'),
        exclude: /node_modules/,
      },
      {
        test: /\.css$/,
        use: removeEmpty([
          ifDev('vue-style-loader', MiniCssExtractPlugin.loader),
          'css-loader',
          'postcss-loader',
        ]),
      },
      {
        test: /\.scss$/,
        use: removeEmpty([
          ifDev('vue-style-loader', MiniCssExtractPlugin.loader),
          'css-loader',
          'postcss-loader',
          {
            loader: 'sass-loader',
            options: {
              implementation: Sass,
              sassOptions: {
                fiber: Fiber,
              },
            },
          },
        ]),
      },
      {
        test: /\.(png|jpe?g|gif|svg|ico)(\?.*)?$/,
        use: {
          loader: 'file-loader',
          options: {
            name: 'assets/images/[name].[hash].[ext]',
          },
        },
      },
      {
        test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
        use: {
          loader: 'file-loader',
          options: {
            name: 'assets/fonts/[name].[hash].[ext]',
          },
        },
      },
    ],
  },

  // splitting out the vendor
  optimization: {
    // bugfix
    minimizer: [
      new TerserPlugin({
        parallel: true,
        cache: true,
      }),
    ],
    namedModules: true,
    splitChunks: {
      name: 'vendor',
      minChunks: 2,
    },
    noEmitOnErrors: true,
    // concatenateModules: true,
  },

  plugins: removeEmpty([

    // create manifest file for server-side asset manipulation
    // create manifest file for server-side asset manipulation
    new ManifestPlugin({
      fileName: 'assets/manifest.json',
      writeToFileEmit: true,
      map: (file, index, array) => {
        const previousItems = array.slice(0, index)
        const rawName = file.name.replace(/(\.[a-f0-9]{32})(\..*)$/, '$2')
        const hasFileAlready = !!previousItems.find(item => item.name === rawName)

        if (hasFileAlready) {
          return {}
        }

        file.name = rawName
        return file
      },
    }),

    // define env
    // new webpack.DefinePlugin({
    // 	'process.env': {
    // 	},
    // }),

    // copy static files
    new CopyWebpackPlugin([
      {
        context: `${srcPath}/assets/static`,
        from: { glob: '**/*', dot: false },
        to: `${buildPath}/assets`,
      },
      {
        context: `${srcPath}/assets/static`,
        from: { glob: '**/*', dot: false },
        to: `${buildPath}/assets/[path][name].[hash].[ext]`,
      },
    ]),

    // enable hot reloading
    ifDev(new webpack.HotModuleReplacementPlugin()),

    // make some packages available everywhere
    // new webpack.ProvidePlugin({
    // 	$: 'jquery',
    // 	jQuery: 'jquery',
    // 	'window.jQuery': 'jquery',
    // }),

    // html
    // new HtmlWebpackPlugin({
    // 	filename: 'index.html',
    // 	template: `${srcPath}/index.html`,
    // 	inject: true,
    // 	minify: ifProd({
    // 		removeComments: true,
    // 		collapseWhitespace: true,
    // 		removeAttributeQuotes: true,
    // 	}),
    // 	buildVersion: new Date().valueOf(),
    // 	chunksSortMode: 'none',
    // }),

    new VueLoaderPlugin(),

    // create css files
    ifProd(new MiniCssExtractPlugin({
      filename: 'assets/css/[name].[hash].css',
      chunkFilename: 'assets/css/[name].[hash].css',
    })),

    // minify css files
    ifProd(new OptimizeCssAssetsPlugin({
      cssProcessorOptions: {
        reduceIdents: false,
        autoprefixer: false,
        zindex: false,
        discardComments: {
          removeAll: true,
        },
      },
    })),

    // svg icons
    new SvgStore({
      prefix: 'icon--',
      svgoOptions: {
        plugins: [
          { cleanupIDs: false },
          { collapseGroups: false },
          { removeTitle: true },
        ],
      },
    }),

    // image optimization
    new ImageminWebpackPlugin({
      optipng: ifDev(null, {
        optimizationLevel: 3,
      }),
      jpegtran: ifDev(null, {
        progressive: true,
        quality: 80,
      }),
      svgo: ifDev(null, {
        plugins: [
          { cleanupIDs: false },
          { removeViewBox: false },
          { removeUselessStrokeAndFill: false },
          { removeEmptyAttrs: false },
        ],
      }),
    }),

  ]),

  node: {
    fs: 'empty',
  },

}
