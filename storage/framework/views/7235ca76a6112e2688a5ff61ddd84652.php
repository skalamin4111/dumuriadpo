[program:php]
priority=5
autostart=true
autorestart=true
stdout_events_enabled=true
stderr_events_enabled=true
command=php-fpm
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
<?php /**PATH phar:///home/sahil/development/office_project/dpoerp/vendor/fly-apps/dockerfile-laravel/builds/dockerfile-laravel/resources/views/fly/supervisor/conf_d/fpm_conf.blade.php ENDPATH**/ ?>