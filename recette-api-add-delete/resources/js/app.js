/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
app.use(PrimeVue)

import CategoryComponent from './components/Category.vue';
import DishComponent from './components/Dish.vue';
import DashboardComponent from './components/Dashboard.vue';

app.component('category-component', CategoryComponent);
app.component('dish-component', DishComponent);
app.component('dashboard-component', DashboardComponent);



app.mount('#app');
