<?php

namespace Biblioteca\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
        //$form = $this->get('fos_user.registration.form');
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->get('fos_user.registration.form.factory');

		$form = $formFactory->createForm();

        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();

            /*****************************************************
             * Add new functionality (e.g. log the registration) *
             *****************************************************/
            $this->get('logger')->info(
                sprintf('New user registration: %s', $user)
            );

            if ($confirmationEnabled) {
                $this->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $this->authenticateUser($user);
                $route = 'fos_user_registration_confirmed';
            }

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->get('router')->generate($route);

            //return new RedirectResponse($url);
        }

        return $this->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}