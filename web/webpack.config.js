const path = require('path')

module.exports = {
  entry: [
    path.resolve(__dirname, 'js', 'main.js'),
  ],
  output: {
    path: path.resolve(__dirname, 'js'),
    filename: 'build.js',
  },
  externals: {
    'jquery': 'jQuery',
  }
}
