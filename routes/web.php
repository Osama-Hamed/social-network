<?php

Route::get('/{any}', 'SinglePageController')->where('any', '.*');
