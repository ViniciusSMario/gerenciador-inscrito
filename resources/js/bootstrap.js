window._ = require('lodash');

/**
 * Carrega o Axios para fazer chamadas HTTP, e configura o CSRF token.
 */
try {
    window.axios = require('axios');

    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
} catch (e) {
    console.error('Erro ao carregar Axios:', e);
}