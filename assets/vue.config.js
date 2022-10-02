// vue.config.js
const { defineConfig } = require('@vue/cli-service')

module.exports = defineConfig({
    devServer: {
        allowedHosts: 'all'
    },
    pluginOptions: {
        i18n: {
            locale: 'ru',
            fallbackLocale: 'en',
            localeDir: 'translations',
            enableInSFC: false
        }
    }
})
