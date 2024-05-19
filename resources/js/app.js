/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import { ZiggyVue  } from '../../vendor/tightenco/ziggy';
import vClickOutside from "click-outside-vue3"
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = createApp({});
app.use(vClickOutside)
app.use(ZiggyVue);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import ExampleComponent from './components/ExampleComponent.vue';
import ClientsList from './components/ClientsList.vue';
import ClientForm from './components/ClientForm.vue';
import ClientShow from './components/ClientShow.vue';

import ClientJournals from './components/ClientJournals.vue';
import NewJournalModal from './components/NewJournalModal.vue';
import ViewJournalModal from './components/ViewJournalModal.vue';

app.component('example-component', ExampleComponent);
app.component('clients-list', ClientsList);
app.component('client-form', ClientForm);
app.component('client-show', ClientShow);
app.component('client-journals', ClientJournals);
app.component('new-journal-modal', NewJournalModal);
app.component('view-journal-modal', ViewJournalModal);
app.mount('#app');
