var webpack = require('webpack');

module.exports = {
  entry: "./web/js/main.js",
  output: {
    filename: "./web/build/build_main.js"
  },
  externals: {
    'jquery': 'jQuery',
  }
}