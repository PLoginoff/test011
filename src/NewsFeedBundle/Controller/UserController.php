<?php

namespace NewsFeedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use NewsFeedBundle\Entity\User;
use NewsFeedBundle\Form\RegisterType;
use NewsFeedBundle\Form\EditPasswordType;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user->generateCode();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $mailer = $this->get('news_feed.phpmailer');
            $mailer->setFrom('fixme@example.com', 'Mailer');
            $mailer->addAddress($user->getEmail());
            $mailer->setSubject('Here is the subject');
            $mailer->setBody(
                "Your activation link: \n".
                $this->generateUrl('activate', ['code' => $user->getCode()]) . "\n" .
                "--\n"
                );
            $mailer->send();
    
            return $this->redirectToRoute('activate_me');
        }

        return $this->render(
                'NewsFeedBundle:User:register.html.twig',
                array('form' => $form->createView())
        );
    }

    /**
     * @Route("/activate/{code}", name="activate")
     * @Route("/activate",        name="activate_me")
     */
    public function activateAction($code=null)
    {
        if ( $code ) {
            $repo = $this->getDoctrine()->getRepository('NewsFeedBundle:User');
            $user = $repo->getByCode($code);
            if ( ! $user ) {
                throw new HttpException(404, "Not found code!");                
            }
            $user->setActive(true);
            $user->setCode(null);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));
 
            return $this->redirectToRoute('password');
        }

        return $this->render(
                'NewsFeedBundle:User:activate.html.twig'
        );
    }

    /**
     * @Route("/password", name="password")
     */
    public function passwordAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditPasswordType::class, $user);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('edit_list');
        }

        return $this->render(
                'NewsFeedBundle:User:password.html.twig',
                array('form' => $form->createView())
        );
    }


    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('NewsFeedBundle:User:login.html.twig',
                array(
                'last_username' => $lastUsername,
                'error' => $error,
        ));
    }




}