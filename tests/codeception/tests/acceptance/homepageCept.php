<?php 
// we instantiate acceptance tester class and use I variable
$I = new AcceptanceTester($scenario);
$I->wantTo('verify that homepage has text lorem');
$I->amOnPage('/');
$I->see('lorem');
//$I->see('lorem', 'h1');  to see lorem within an h1 tag. Heading says lorem
$I->wantTo('verify that product apple exists');
$I->click('Apple');
$I->wantTo('verify that i have reached apple product page');
$I->seeCurrentUrlEquals('/product/apple/') ;
date_default_timezone_set('America/New_York'); // to avoid timezone error (http://stackoverflow.com/questions/8811603/how-to-fix-php-errors-related-to-timezone-function-strtotime-and-function-date)
//$I->wantTo('want to add one qty to cart');
$I->click('.single_add_to_cart_button');
$I->see('View Cart');
//$I->click('View Cart');
$I->click('.woocommerce-message a.button.wc-forward');
$I->wantTo('verify that am on cart page');
$I->seeCurrentUrlEquals('/cart/') ;
$I->click('Proceed to Checkout');
$I->seeCurrentUrlEquals('/checkout/') ;
$I->expect('the form is submitted correctly');
$I->fillField('billing_first_name', 'Sumeet');
$I->fillField('billing_last_name','1234');
$I->fillField('billing_company','XYZ');
$I->fillField('billing_email','sumeetsarna123@gmail.com');
$I->fillField('billing_phone','123456789');
//$I->selectOption('.country_to_state','Netherlands');
$I->fillField('billing_address_1','any address');
$I->fillField('billing_city','Pune');
$I->selectOption('.state_select','Maharashtra');
$I->fillField('billing_postcode','411001');
//$I->see('Place order');
//$I->click('Place order');
$I->click('input#place_order');
//$I->click("//input[@id='place_order']");
//$I->click(['id' => 'place_order']);
//$I->click('Place order', '.button.alt' );
//$I->see('Order Received','h1');
$I->see('Thank you. Your order has been received.');
// what do i expect 
?>