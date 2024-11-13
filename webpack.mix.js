const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .vue()
   .version();
mix.js('resources/js/admin/app.js', 'public/adminjs')
   .vue()
  .version();
