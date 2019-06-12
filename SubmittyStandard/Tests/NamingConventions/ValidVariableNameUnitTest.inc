<?php

$varName = 'hello';
$var_name = 'hello';
$varname = 'hello';

class MyClass {
    $varName = 'hello';
    $var_name = 'hello';
    $varname = 'hello';

    public $varName = 'hello';
    public $var_name = 'hello';
    public $varname = 'hello';

    protected $varName = 'hello';
    protected $var_name = 'hello';
    protected $varname = 'hello';

    private $varName = 'hello';
    private $var_name = 'hello';
    private $varname = 'hello';
}

echo $varName;
echo $var_name;
echo $varname;

echo "Hello $varName";
echo "Hello $var_name";
echo "Hello $varname";
echo "Hello ${varName}";
echo "Hello ${var_name}";
echo "Hello ${varname}";

echo 'Hello '.$varName;
echo 'Hello '.$var_name;
echo 'Hello '.$varname;

echo $_SERVER['var_name'];
echo $_REQUEST['var_name'];
echo $_GET['var_name'];
echo $_POST['var_name'];
echo $GLOBALS['var_name'];

echo MyClass::$varName;
echo MyClass::$var_name;
echo MyClass::$varname;

echo $this->varName2;
echo $this->var_name2;
echo $this->varname2;
echo $object->varName2;
echo $object->var_name2;
echo $object_name->varname2;

echo $this->myFunction($one, $two);
echo $object->myFunction($oneTwo);

$error = "format is \$GLOBALS['$varName']";
$error = "format is \$GLOBALS['$var_name']";

echo $_SESSION['var_name'];
echo $_FILES['var_name'];
echo $_ENV['var_name'];
echo $_COOKIE['var_name'];

$varName   = 'hello';
$var_name  = 'hello';
$varname   = 'hello';

echo "{$_SERVER['HOSTNAME']} $varName";
