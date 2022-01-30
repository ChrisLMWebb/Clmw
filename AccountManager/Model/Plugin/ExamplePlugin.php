<?php
namespace Clmw\AccountManager\Plugin;

class ExamplePlugin{

    public function afterGetTitle(\Mageplaza\HelloWorld\Controller\Index\Example $subject, $result)
    {

        echo __METHOD__ . "</br>";

        return '<h1>'. $result . 'Mageplaza.com' .'</h1>';

    }

}
