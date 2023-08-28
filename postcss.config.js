module.exports = {
    plugins: [
      // https://github.com/postcss/autoprefixer
      require('autoprefixer'),

      // https://github.com/elchininet/postcss-rtlcss
      // If you want to support RTL css, then
      // 1. yarn/npm install postcss-rtlcss
      // 2. optionally set quasar.config.js > framework > lang to an RTL language
      // 3. uncomment the following line:
      require('postcss-rtlcss')
    ]
  }
