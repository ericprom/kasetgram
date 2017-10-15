import Vue from 'vue'
import VueI18n from 'vue-i18n'
import swal from 'sweetalert2'

Vue.use(VueI18n)

const { locale, translations } = window.config

const i18n = new VueI18n({
  locale,
  messages: {
    [locale]: translations
  }
})
swal.setDefaults({
  reverseButtons: true,
  confirmButtonText: 'ok',
  cancelButtonText: 'cancel'
})

export default i18n
