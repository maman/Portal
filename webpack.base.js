require('dotenv').config();

const path = require('path');
const webpack = require('webpack');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

const basedir = path.resolve(__dirname, 'public');
const WEBPACK_APP_URL = process.env.WEBPACK_APP_URL;
const WEBPACK_PORT = process.env.WEBPACK_PORT;
const ASSETS_URL = process.env.APP_ASSETS_URL;

module.exports = {
  entry: path.resolve(basedir, 'js', 'main.js'),
  devtool: 'inline-source-map',
  resolve: {
    alias: {
      waypoints: 'waypoints/lib',
    },
  },
  module: {
    rules: [
      {
        test: /\.less$/,
        use: [
          {
            loader: 'style-loader',
          },
          {
            loader: 'css-loader',
          },
          {
            loader: 'less-loader',
            options: {
              noIeCompat: true,
            },
          },
        ],
      },
      {
        test: /\.js$/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: [
              [
                'env',
                {
                  targets: {
                    browsers: ['last 2 versions'],
                  },
                },
              ],
            ],
          },
        },
      },
    ],
  },
  devServer: {
    contentBase: path.resolve(basedir),
    compress: true,
    port: WEBPACK_PORT,
    hot: true,
    proxy: {
      '*': WEBPACK_APP_URL,
    },
  },
  plugins: [
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery',
    }),
    new webpack.HotModuleReplacementPlugin(),
    new BrowserSyncPlugin(
      {
        open: false,
        port: WEBPACK_PORT,
        proxy: ASSETS_URL,
        notify: false,
        files: [
          {
            match: ['app/**/*.php', 'app/**/*.twig'],
            fn: evt => {
              if (evt === 'change') {
                /** Patch browsersync to reload page */
                const bs = require('browser-sync').get('bs-webpack-plugin'); // eslint-disable-line
                bs.reload();
              }
            },
          },
        ],
      },
      {
        reload: false,
      }
    ),
  ],
  output: {
    filename: 'main.bundle.js',
    path: path.resolve(basedir, 'js', 'dist'),
    publicPath: '/js/dist/',
  },
};
