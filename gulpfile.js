var elixir = require('laravel-elixir');

elixir.config.publicPath = 'Assets';

elixir(function(mix) {
    mix.less(['panel.less'], 'Assets/css/panel.min.css');
});

elixir(function(mix) {
    mix.styles(['vendor/sweetalert.css'], 'Assets/css/vendor/sweetalert.min.css')
});

elixir(function(mix) {
    mix.scripts([
        'vendor/bloodhound.js',
        'vendor/bootstrap.js',
        'vendor/jquery.mask.js',
        'vendor/moment/moment.js',
        'vendor/moment/locale-pt-br.js',
        'vendor/typeahead.js',
        'vendor/sweetalert.min.js',
        'vendor/fileupload.js'
    ], 'Assets/js/vendor/compiled.min.js');
});

elixir(function(mix) {
    mix.scripts([
        'app.js',
        'errors.js',
        'masks.js',
        'message.js',
        'panel.js',
        'setting.js',
        'alert.js'
    ], 'Assets/js/app/compiled.min.js');
});

elixir(function(mix) {
    mix.version([
        'Assets/js/vendor/compiled.min.js',
        'Assets/js/app/compiled.min.js',
        'Assets/css/vendor/sweetalert.min.css',
        'Assets/css/panel.min.css',
    ])
});