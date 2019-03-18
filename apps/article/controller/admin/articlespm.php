<?php

class controller_admin_articlespm extends article_controller_abstract
{
    function __construct($app)
    {
        parent::__construct($app);
    }

    function cron()
    {
        @set_time_limit(600);

        $queue = factory::queue('articlespm');
        $interval_size = config('articlespm', 'interval_size', 10);

        $json = array(
            'state' => true,
            'info' => $queue->interval($interval_size),
        );
        exit ($this->json->encode($json));
    }
}