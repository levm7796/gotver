import '../bootstrap';
import { createApp } from 'vue';
import store from "./store.js";
const app = createApp({})
app.use('less')

import DropDown from './components/DropDown.vue';
app.component('drop-down', DropDown);

import TagsBox from './components/tagsbox.vue';
app.component('tagsbox', TagsBox);

import Blocks3 from './components/blocks3.vue';
app.component('blocks3', Blocks3);

import newsBlocks from './components/newsBlocks.vue';
app.component('news-blocks', newsBlocks);

import PhoneInput from './components/PhoneInput.vue';
app.component('phone-input', PhoneInput);

import LocationSelector from './components/LocationSelector.vue';
app.component('location-selector', LocationSelector);

import hubSelector from './components/HubSelector.vue';
app.component('hub-selector', hubSelector);

import LinkGenerator from './components/LinkGenerator.vue';
app.component('link-generator', LinkGenerator);

import MenuLinks from './components/MenuLinks.vue';
app.component('menu-links', MenuLinks);

import History from './components/History.vue';
app.component('history', History);

import addSvg from './components/addSvg.vue';
app.component('add-svg', addSvg);

import HistoryItems from './components/HistoryItems.vue';
app.component('history-items', HistoryItems);

import IconBox from './components/iconbox2.vue';
app.component('iconbox', IconBox);

import OptionBox from './components/optionbox.vue';
app.component('optionbox', OptionBox);

import SocialBox from './components/socialbox.vue';
app.component('socialbox', SocialBox);

import HotelImage from './components/hotelImage.vue';
app.component('hotel-image', HotelImage);

import NewImage from './components/newImage.vue';
app.component('new-image', NewImage);

import Froala from './components/Froala.vue';
app.component('froala', Froala);


// Require Froala Editor js file.
require('froala-editor/js/froala_editor.pkgd.min.js')    // Require Froala Editor css files.
require('froala-editor/css/froala_editor.pkgd.min.css')
require('froala-editor/css/froala_style.min.css')    // Import and use Vue Froala lib.
import VueFroala from 'vue-froala-wysiwyg'
app.use(VueFroala)

app.use(store)

app.mount('#app');
