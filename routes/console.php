<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:handle-expire-poll')->everyMinute();
