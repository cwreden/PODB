<?php
/**
 * Created by IntelliJ IDEA.
 * User: openworkers
 * Date: 12.10.13
 * Time: 10:30
 * To change this template use File | Settings | File Templates.
 */

namespace OSWAssetHelper;


class Module
{

    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'compileAssets' => 'OSWAssetHelper\CompileAssets',
            )
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}