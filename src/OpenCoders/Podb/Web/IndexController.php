<?php

namespace OpenCoders\Podb\Web;

use OpenCoders\Podb\Manager;
use Symfony\Component\HttpFoundation\Request;
use Twig_Environment;

class IndexController
{
    /**
     * @var Twig_Environment
     */
    private $twig;
    /**
     * @var Manager
     */
    private $manager;

    /**
     * @param Twig_Environment $twig
     * @param Manager $manager
     */
    public function __construct(
        Twig_Environment $twig,
        Manager $manager
    ) {
        $this->twig = $twig;
        $this->manager = $manager;
    }

    public function index(Request $request)
    {
        $session = $request->getSession();

        // TODO extract lock screen to separate service
//        if ($session->has('attributes')
//            && isset($session->get('attributes')['locked'])
//            && $session->get('attributes')['locked'] === true
//            || $session->get('locked')
//        ) {
//            return $this->twig->render('lockscreen.html');
//        }
        return $this->twig->render('base.html', array(
            'app' => array(
                'name' => $this->manager->getApplicationName()
            )
        ));
    }
}
