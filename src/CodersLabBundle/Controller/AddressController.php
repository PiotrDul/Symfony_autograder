<?php

namespace CodersLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CodersLabBundle\Entity\Email;
use Symfony\Component\HttpFoundation\Request;

class AddressController extends Controller
{
    /**
     * @Route("/newEmail")
     */
    public function newEmailAction(Request $request)
    {
        $isAddresInvalid = false;
        $session = $request->getSession();
          
        if($request->isMethod('POST') && !is_null($request->request->get('userEmail'))  ) {
            $address = $request->request->get('userEmail');

            if (filter_var($address, FILTER_VALIDATE_EMAIL)) { 
                $userToken = $session->getId().time();  
                $newEmail = new Email();
                $newEmail->setAddress($address);
                $newEmail->setUserToken($userToken);
                $em = $this->getDoctrine()->getManager();   
                $em->persist( $newEmail);    
                $em->flush(); 
                
                return $this->redirect($this->generateUrl('coderslab_address_succesadd', array('token' => $userToken)));
            }else{
                $isAddresInvalid = true;
            }         

        }
        
         if($session->get('userToken') != null){
            return $this->redirect($this->generateUrl('coderslab_address_userexist'));
        }
        
        return $this->render('CodersLabBundle:Address:new_email.html.twig', array(
            'isAddresInvalid' => $isAddresInvalid
        ));
    }

    /**
     * @Route("/succesAdd/{token}")
     */
    public function succesAddAction(Request $request, $token)
    {
        $session = $request->getSession();
        $session->set('userToken', $token); 
        
        return $this->render('CodersLabBundle:Address:succes_add.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/userExist")
     */
    public function userExistAction(Request $request)
    {
        $isEdit = false;
        
        $session = $request->getSession();
        $userToken = $session->get('userToken');
        $repository = $this->getDoctrine()->getRepository('CodersLabBundle:Email');
        if($userToken != null){
            $userEmailEntity = $repository->findOneByUserToken($userToken);
            $email = $userEmailEntity->getAddress();
        }
        
        if($request->isMethod('POST')){            
                $address = $request->request->get('address');
           if ( filter_var($address, FILTER_VALIDATE_EMAIL)) {
                $userEmailEntity->setAddress($address);
                $em = $this->getDoctrine()->getManager();   
                $em->persist( $userEmailEntity);    
                $em->flush();  
                
                $isEdit = true;
            }
        }
        
        return $this->render('CodersLabBundle:Address:user_exist.html.twig', array(
            'isEdit' => $isEdit,
            'email' => $email,
            'userToken' => $userToken
        ));
    }

    /**
     * @Route("/deleteEmail/{userToken}")
     */
    public function deleteEmailAction(Request $request, $userToken)
    {
        $repository = $this->getDoctrine()->getRepository('CodersLabBundle:Email');
        $userEmailEntity = $repository->findOneByUserToken($userToken);
        $em = $this->getDoctrine()->getManager();   
        $em->remove( $userEmailEntity);    
        $isDelete = $em->flush(); 
        
        $session = $request->getSession();
        $session->remove('userToken');
        
        return $this->render('CodersLabBundle:Address:delete_email.html.twig', array(
            'isDelete' => $isDelete
        ));
    }

}
