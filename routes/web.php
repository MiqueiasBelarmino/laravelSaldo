<?php
$this->group(['middleware' => ['auth']], function(){
    
    $this->get('balance', 'BalanceController@index')->name('admin.balance');

    $this->get('withdraw', 'BalanceController@withdraw')->name('balance.withdraw');
    $this->post('withdraw', 'BalanceController@withdrawStore')->name('withdraw.store');
    
    $this->post('deposit', 'BalanceController@depositStore')->name('deposit.store');
    $this->get('deposit', 'BalanceController@deposit')->name('balance.deposit');
   
    $this->post('transfer', 'BalanceController@transferStore')->name('transfer.store');
    $this->get('transfer', 'BalanceController@transfer')->name('balance.transfer');
    $this->post('confirmTransfer', 'BalanceController@confirmTransfer')->name('confirm.transfer');
    
    $this->get('admin','AdminController@index')->name('admin.home');
});


$this->get('/', 'SiteController@index')->name('home');



Auth::routes();
