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
               - Create Role: \$ php console.php rbacadmin cr role_name\r\n
               - Delete Role: \$ php console.php rbacadmin dr role_name\r\n
               - Assign User to Role: \$ php console.php rbacadmin autr rolename username\r\n
               - Revoke Role From User: \$ php console.php rbacadmin rrfu rolename username\r\n
               - View User assignments (roles): \$ php console.php rbacadmin vua username\r\n
               - View All Roles: \$ php console.php rbacadmin var\r\n";
        echo "\r\n\r\n";
    }

    public function run($args)
    {
        $this->rAuthManager = Yii::app()->authManager;

        //print_r($args);

        switch ($args[0])
        {
            case "var":

                $aRole = $this->rAuthManager->getRoles();

                if(empty($aRole))
                {
                    echo "\r\n\r\nThere are no roles in the system, use \"\$ php console.php rbacadmin cr role_name\" to create one.\r\n";
                }
                else
                {
                    echo "\r\n\r\nAll Roles:\r\n";
                    foreach ($aRole as $sRoleName=>$oCAuthItem)
                    {
                        echo "- {$sRoleName}\r\n";
                    }
                }

                echo "\r\n";
                break;

            case "co":
                if ((empty($args[1])) || (empty($args[2])))
                {
                    echo "\r\nThe create operation action is missing one or more arguments.\r\n";
                }
                else
                {
                    $fResult = $this->createOperation($args[1], $args[2]);
                    echo ($fResult) ? "\r\nCreate operation action successful\r\n" : "\r\nCreate operation action failed\r\n";
                }
                break;

            case "cr":
                if (empty($args[1]))
                {
                    echo "\r\nThe create role action is missing an argument.\r\n";
                }
                else
                {
                    $fResult = $this->createRole($args[1]);
                    echo ($fResult) ? "\r\nCreate role action successful\r\n" : "\r\nCreate role action failed\r\n";
                }
                break;

            case "dr":
                if (empty($args[1]))
                {
                    echo "\r\nThe delete role action is missing an argument.\r\n";
                }
                else
                {
                    $fResult = $this->deleteRole($args[1]);
                    echo ($fResult) ? "\r\nDelete role action successful\r\n" : "\r\nDelete role action failed\r\n";
                }
                break;

            case "autr":
                if ((empty($args[1])) || (empty($args[2])))
                {
                    echo "\r\nThe assign user to role action is missing an argument.\r\n";
                }
                else
                {
                    $fResult = $this->assignUserToRole($args[1], $args[2]);
                    echo ($fResult) ? "\r\nAssign user to role action successful\r\n" : "\r\nAssign user to role action failed\r\n";
                }
                break;

            case "rrfu":
                if ((empty($args[1])) || (empty($args[2])))
                {
                    echo "\r\nThe revoke role from user action is missing an argument.\r\n";
                }
                else
                {
                    $fResult = $this->revokeUserFromRole($args[1], $args[2]);
                    echo ($fResult) ? "\r\nRevoke role from user action successful\r\n" : "\r\nRevoke role from user action failed\r\n";
                }
                break;

            case "vua":
                if (empty($args[1]))
                {
                    echo "\r\nThe view user assignments action is missing an argument.\r\n";
                }
                else
                {
                    $aUserAssignments = $this->viewUserAssignments($args[1]);
                    if (empty($aUserAssignments))
                    {
                        echo "\r\nThe user has no assignments.\r\n";
                    }
                    else
                    {

                        echo "\r\n\r\nRoles assigned to {$args[1]}:\r\n";
                        foreach ($aUserAssignments as $sRoleName=>$oCAuthItem)
                        {
                            echo "- {$sRoleName}\r\n";
                        }

                        echo "\r\n";
                    }

                }
                break;

            default:
                echo "\r\nYour entry did not match any options, please try again.\r\n";
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

    private function createRole($sRoleName)
    {
        return $this->rAuthManager->createRole($sRoleName);
    }

    private function deleteRole($sRoleName)
    {
        return $this->rAuthManager->removeAuthItem($sRoleName);
    }

    private function assignUserToRole($sRoleName, $sUserName)
    {
        return $this->rAuthManager->assign($sRoleName, $sUserName);
    }

    private function revokeUserFromRole($sRoleName, $sUserName)
    {
        return $this->rAuthManager->revoke($sRoleName, $sUserName);
    }

    private function viewUserAssignments($sUserName)
    {
        return $this->rAuthManager->getAuthAssignMents($sUserName);
    }
}