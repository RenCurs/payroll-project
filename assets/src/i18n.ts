import Vue from 'vue'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n)

// Загрузка всех локалей и сохранение контекста
function loadMessages() {
    const context = require.context('./translations', true, /[a-z0-9-_]+\.json$/i);
    const messages = {}

    context.keys().map((key) => {
        const matched = key.match(/([A-Za-z0-9-_]+)\./i) ?? []
        if (matched.length > 1) {
            const locale = matched[1]
            messages[locale] = context(key)
        }

        return messages
    })

    return messages
}

export default new VueI18n(
    {
        locale: process.env.VUE_APP_I18N_LOCALE,
        fallbackLocale: process.env.VUE_APP_I18N_FALLBACK_LOCALE || 'en',
        messages: loadMessages()
    }
)
