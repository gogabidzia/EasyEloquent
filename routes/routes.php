<?php


$route->get('/', 'HomeController@index')->name('index')->middleware('Admin');