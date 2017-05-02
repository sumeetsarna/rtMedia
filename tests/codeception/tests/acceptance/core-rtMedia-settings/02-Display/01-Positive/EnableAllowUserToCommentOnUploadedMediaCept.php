<?php

/**
* Scenario : To Allow the user to comment on uploaded media.
*/
    use Page\Login as LoginPage;
    use Page\Logout as LogoutPage;
    use Page\UploadMedia as UploadMediaPage;
    use Page\DashboardSettings as DashboardSettingsPage;
    use Page\Constants as ConstantsPage;
    use Page\BuddypressSettings as BuddypressSettingsPage;

    $commentStr = 'test comment';

    $I = new AcceptanceTester( $scenario );
    $I->wantTo( 'To check if the user is allowed to comment on uploaded media' );

    $loginPage = new LoginPage( $I);
    $loginPage->loginAsAdmin( ConstantsPage::$userName, ConstantsPage::$password );

    $settings = new DashboardSettingsPage( $I );
    $settings->gotoTab( ConstantsPage::$displayTab, ConstantsPage::$displayTabUrl );
    $settings->verifyEnableStatus( ConstantsPage::$strCommentCheckboxLabel, ConstantsPage::$commentCheckbox );

    $buddypress = new BuddypressSettingsPage( $I );
    $buddypress->gotoMedia( ConstantsPage::$userName );
    $temp = $buddypress->countMedia( ConstantsPage::$mediaPerPageOnMediaSelector ); // $temp will receive the available no. of media

    $uploadmedia = new UploadMediaPage( $I );

    if( $temp >= ConstantsPage::$minValue ){

        $I->scrollTo( ConstantsPage::$mediaPageScrollPos );

        $uploadmedia->fisrtThumbnailMedia();

        $I->scrollTo( ConstantsPage::$commentLink );

        $I->seeElement( UploadMediaPage::$commentTextArea );
        $I->fillfield( UploadMediaPage::$commentTextArea, $commentStr );
        $I->click( UploadMediaPage::$commentSubmitButton );

        $I->waitForText( $commentStr, 10 );

    }else{

        $I->amOnPage( '/wp-admin' );
        $I->waitForElement( LoginPage::$dashBoardMenu, 5 );

        $settings->gotoTab( ConstantsPage::$displayTab, ConstantsPage::$displayTabUrl );
        $settings->verifyDisableStatus( ConstantsPage::$strDirectUplaodCheckboxLabel, ConstantsPage::$directUploadCheckbox, ConstantsPage::$masonaryCheckbox ); //This will check if the direct upload is disabled

        $buddypress->gotoMedia( ConstantsPage::$userName );

        $uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$userName, ConstantsPage::$imageName, ConstantsPage::$photoLink);

        $I->reloadPage();
        $I->waitForElement( ConstantsPage::$profilePicture, 5 );

        $I->scrollTo( ConstantsPage::$mediaPageScrollPos );

        $uploadmedia->fisrtThumbnailMedia();

        $I->scrollTo( ConstantsPage::$commentLink );

        $I->seeElement( UploadMediaPage::$commentTextArea );
        $I->fillfield( UploadMediaPage::$commentTextArea, $commentStr );
        $I->click( UploadMediaPage::$commentSubmitButton );

        $I->waitForText( $commentStr, 10 );

    }

    $logout = new LogoutPage( $I );
    $logout->logout();

?>