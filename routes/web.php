<?php
$this->group(['middleware' => ['auth']], function(){
    $this->get('withdraw', 'BalanceController@withdraw')->name('balance.withdraw');
    $this->post('withdraw', 'BalanceController@withdrawStore')->name('withdraw.store');
    $this->post('deposit', 'BalanceController@depositStore')->name('deposit.store');
    $this->get('deposit', 'BalanceController@deposit')->name('balance.deposit');
    $this->get('balance', 'BalanceController@index')->name('admin.balance');

    $this->get('admin','AdminController@index')->name('admin.home');
});


$this->get('/', 'SiteController@index')->name('home');



Auth::routes();
