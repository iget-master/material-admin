var elixir = require('laravel-elixir');

elixir.config.publicPath = 'Assets';

elixir(function(mix) {
    mix.less('panel.less', 'Assets/css/panel.min.css');
});