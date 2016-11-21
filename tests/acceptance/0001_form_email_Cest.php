<?php 

class FormCest
{
    public function _before(FunctionalTester $I)
    {
        
    }

    public function _after(FunctionalTester $I)
    {
        
    }
    
    public function formTest(AcceptanceTester $I)
    {
      
        $I->wantTo('Test fomularza zły email');
        $mail = "testmail";
        $I->amOnPage("/");
        $I->submitForm('form', [
             'userEmail' => $mail,
        ]);
        $I->see('Niepoprawny email');
        
    }
    
}
  