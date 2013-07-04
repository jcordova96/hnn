<?php
/**
 * User: dataskills dataskills@gmail.com
 * Date: 7/3/13
 * Time: 4:32 PM
 */

class RbacAdminCommand extends CConsoleCommand
{

    private $rAuthManager = null;

    public function getHelp()
    {
        $auth = Yii::app()->authManager;
        echo "RBAC admin\r\n\r\n";
        echo "Usage:\r\n
               - Create operation: \$ php console.php rbacadmin co operation_name operation_description\r\n
               - Add Role to Operation: \$ php console.php rbacadmin arto operation_name operation_description\r\n
               - Create Role: \$ php console.php rbacadmin cr role_name\r\n
               - Assign User to Role: \$ php console.php rbacadmin autr username rolename\r\n";
    }

    public function run($args)
    {
        $this->rAuthManager = Yii::app()->authManager;

        print_r($args);

        switch ($args[0])
        {
            case "co":
                if((empty($args[1]))||(empty($args[2])))
                {
                    
                }
                else
                {

                }
                break;

        }
    }

    private function createOperation($sOperationName, $sOperationDescription)
    {
        return $this->rAuthManager->createOperation($sOperationName, $sOperationDescription);
    }

    private function addRoleToOperation($sOperationName, $sRoleName)
    {
        return $this->rAuthManager->addItemChild($sOperationName, $sRoleName);
    }
}