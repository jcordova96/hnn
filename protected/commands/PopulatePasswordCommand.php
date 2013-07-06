<?php
/**
 * User: dataskills dataskills@gmail.com
 * Date: 7/2/13
 * Time: 10:36 AM
 */

class PopulatePasswordCommand extends CConsoleCommand
{
    private $rPasswordGuide = "_dev_pw_guide.csv";

    public function getHelp()
    {
        echo "Run this job without args to set a password to user objects that do not have a password.";
        echo "\r\n\r\n";
    }

    public function run($args)
    {
        echo "\r\nProcess running\r\n\r\n";
        $this->process();
    }

    public function process()
    {
        die("process deactivated");

        $aPasswordFileData = "";

//        $criteria = new CDbCriteria;
//        $criteria->condition = 'id > :idMin AND id < :idMax';
//        $criteria->params = array(':idMin'=>12000,'idMax'=>14001);

        $users = User::model()->findAll();

        echo "Writing password help file ... \r\n\r\n";

        $fp = fopen($this->rPasswordGuide,"a+");

        foreach ($users as $user)
        {
            if (filter_var($user->mail, FILTER_VALIDATE_EMAIL))
            {
                $sTempPassword = $this->setPassword($user);

                fputcsv($fp,array($user->id,$user->mail,$sTempPassword));
            }
        }

        fclose($fp);

        echo "Process FINISHING ... \r\n\r\n";
    }

    private function setPassword($user)
    {
        $sTempPassword = $this->generateTempPassword();
        $user->pass = crypt($sTempPassword);
        $fResult = $user->save();
        return $sTempPassword;
    }

    public function generateTempPassword()
    {
        $str = md5(rand((rand(0, 499)), (rand(500, 1001))));
        return substr($str, 0, 9);
    }
}