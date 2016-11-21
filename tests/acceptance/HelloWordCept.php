<?php 
$i = new AcceptanceTester($scenario);
$i->wantTo('Strona główna');
$i->amOnPage('/');
$i->see('Welcome');


