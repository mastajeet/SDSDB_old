<?php
require_once("helper/PasswordGetter.php");
require_once("app/Variable.php");
class TestPasswordGetter extends PHPUnit_Framework_TestCase{

    private $password_getter;

    /**
     * @before
     */
    function setup_mocks_and_initialize_password_getter(){
        $this->mocked_variable = $this->getMockBuilder(Variable::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->password_getter = new PasswordGetter($this->mocked_variable);
    }


    function test_whenGetSuperAdminPassWord_thenCallGetSuperAdminPasswordFromVariable(){
        $this->mocked_variable->expects($this->once())
            ->method('get_super_admin_password');

        $this->password_getter->get_super_admin_password();
    }

}