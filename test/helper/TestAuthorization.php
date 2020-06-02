<?php

require_once('helper/Authorization.php');
require_once('helper/PasswordGetter.php');

class TestAuthorization extends PHPUnit_Framework_TestCase
{
    const GOOD_PASSWORD = "good_password";
    const BAD_PASSWORD = "bad_password";

    private $mocked_password_getter;

    /**
     * @before
     */
    function setup_mock(){
        $this->mocked_password_getter = $this->getMockBuilder(PasswordGetter::class)
                                        ->disableOriginalConstructor()
                                        ->getMock();

        $this->mocked_password_getter->method('get_super_admin_password')
            ->willreturn(self::GOOD_PASSWORD);
    }

    function test_givenAuthentifiedAdmin_whenVerifySuperAdmin_thenReturnFalse(){
        $authorization = new Authorization($this->mocked_password_getter);
        $fake_cookie = array(Authorization::KEY_AUTHORIZATION_LEVEL => Authorization::AUTHORIZATION_LEVEL_BUREAU,
                             Authorization::KEY_PASSWORD => self::GOOD_PASSWORD);

        $is_authorized = $authorization->verifySuperAdmin($fake_cookie);

        $this->assertFalse($is_authorized);
    }

    /**
     * @expectedException     MissingAuthorizationCredentialsException
     */
    function test_givenMissingAdminCredentials_whenVerifySuperAdmin_thenRaiseArgumentCountError(){
        $authorization = new Authorization($this->mocked_password_getter);
        $fake_cookie = array(Authorization::KEY_AUTHORIZATION_LEVEL => Authorization::AUTHORIZATION_LEVEL_BUREAU);

        $is_authorized = $authorization->verifySuperAdmin($fake_cookie);
    }

    function test_givenAuthentifiedSuperAdmin_whenVerifySuperAdmin_thenReturnTrue(){
        $authorization = new Authorization($this->mocked_password_getter);
        $fake_cookie = array(Authorization::KEY_AUTHORIZATION_LEVEL => Authorization::AUTHORIZATION_LEVEL_SUPER_ADMIN,
            Authorization::KEY_PASSWORD => self::GOOD_PASSWORD);

        $is_authorized = $authorization->verifySuperAdmin($fake_cookie);

        $this->assertTrue($is_authorized);
    }

    function test_givenAuthentifiedSuperAdminWithWrongPassword_whenVerifySuperAdmin_thenReturnFalse(){
        $authorization = new Authorization($this->mocked_password_getter);
        $fake_cookie = array(Authorization::KEY_AUTHORIZATION_LEVEL => Authorization::AUTHORIZATION_LEVEL_SUPER_ADMIN,
            Authorization::KEY_PASSWORD => self::BAD_PASSWORD);

        $is_authorized = $authorization->verifySuperAdmin($fake_cookie);

        $this->assertFalse($is_authorized);
    }
}

