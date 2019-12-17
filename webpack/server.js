import path from 'path'
import browserSync from 'browser-sync'
import webpack from 'webpack'
import httpProxyMiddleware from 'http-proxy-middleware'
import webpackDevMiddleware from 'webpack-dev-middleware'
import webpackHotMiddleware from 'webpack-hot-middleware'
import chokidar from 'chokidar'
import config from './webpack.config'
import { sassImport } from './utilities'
import { srcPath, sassImportPath } from './paths'

const bundler = webpack(config)
const middlewares = []

// define proxy (e.g. for api calls)
// middlewares.push(httpProxyMiddleware('/api', {
// 	target: 'http://local.supertype.io',
// 	changeOrigin: true,
// 	pathRewrite: {
// 		'^/api': '',
// 	},
// }))

// middlewares.push(httpProxyMiddleware('/uploads', {
// 	target: 'http://local.supertype.de',
// 	changeOrigin: true,
// }))

// add webpack stuff
middlewares.push(webpackDevMiddleware(bundler, {
  publicPath: config.output.publicPath,
  stats: {
    colors: true,
    chunks: false,
  },
}))

// add hot reloading
middlewares.push(webpackHotMiddleware(bundler))

// start browsersync
const url = 'http://localhost'
const bs = browserSync.create()
const server = bs.init({
  proxy: {
    target: url,
    middleware: middlewares,
  },
  files: [
    'src/resources/**/*.php',
    'src/app/**/*.php',
    '!**/node_modules/**',
  ],
  logLevel: 'silent',
  open: false,
  notify: false,
  injectChanges: false,
  ghostMode: {
    clicks: false,
    forms: false,
    scroll: false,
  },
})

console.log(`${url}:${server.options.get('port')}`)

// sass import
bs.watch(path.join(sassImportPath, '**/!(index|index_sub).scss'), { ignoreInitial: true }, () => {
  sassImport(sassImportPath)
})
