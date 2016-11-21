<?php 



$I = new AcceptanceTester($scenario);
$I->wantTo('Test fomularza dobry email');
$mail = "testmail@wp.pl";
$I->amOnPage("/");
$I->submitForm('form', [
     'userEmail' => $mail,
]);
$I->see('Adres dodany');
  