<?php
/**
 * Created by PhpStorm.
 * User: bslabach
 * Date: 3/30/18
 * Time: 7:40 PM
 */

#region Create Matches Function


if (isset($_POST['createSGLSID'])){

    createSGLSMatches();

    //unset($_POST['createSGLSID']);

    //echo $_POST['createSGLSID'];
}

#endregion
