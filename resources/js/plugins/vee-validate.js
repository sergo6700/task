import Vue from 'vue';
import {ValidationProvider, extend} from 'vee-validate';
import {required} from 'vee-validate/dist/rules';
import {confirmed} from 'vee-validate/dist/rules';
import {email} from 'vee-validate/dist/rules';
import {min} from 'vee-validate/dist/rules'
import { ValidationObserver } from 'vee-validate';
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);


extend('required',{
    ...required,
    message: 'This field is required!'
});
extend('min',{
    ...min,
    message: 'The password should be minimum 6 characters!'
});
extend('confirmed',{
    ...confirmed,
    message: 'Invalid password confirmation!'
});
extend('email', {
    ...email,
    message: 'Please enter valid email!'
});