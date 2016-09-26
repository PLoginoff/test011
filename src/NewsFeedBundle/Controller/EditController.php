<?php

namespace NewsFeedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use NewsFeedBundle\Entity\Article;
use NewsFeedBundle\Form\ArticleType;

use NewsFeedBundle\ResizeImage;

use Symfony\Component\HttpKernel\Exception\HttpException;

class EditController extends Controller
{
    /**
     * @Route("/edit/list", name="edit_list")
     */
    public function listAction()
    {
        $repo = $this->getDoctrine()->getRepository('NewsFeedBundle:Article');
        $list = $repo->getListForUser($this->getUser());

        return $this->render(
            'NewsFeedBundle:Edit:list.html.twig', [
            'list' => $list
            ]
        );
    }

    /**
     * @Route("/edit/new", name="edit_new")
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUser($this->getUser());

            /**
 * @var Symfony\Component\HttpFoundation\File\UploadedFile $file 
*/
            $file = $article->getPhoto();
            $fileName = md5(uniqid()).'.jpg';

            $uploadFile = $file->move(
                $this->getParameter('article_img'),
                $fileName
            );

            $dir  = $this->getParameter('article_img');
            $full = $dir . '/' . $fileName;

            $resizer = new ResizeImage($full);
            $resizer->resize(100, 100);

            $article->setPhoto($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('edit_list');
        }

        return $this->render(
            'NewsFeedBundle:Edit:new.html.twig', array(
            'form' => $form->createView()
            )
        );
    }


    /**
     * @Route("/edit/remove/{id}", name="edit_remove")
     */
    public function removeAction($id)
    {
        $repo = $this->getDoctrine()->getRepository('NewsFeedBundle:Article');
        $article  = $repo->getOneForUser($this->getUser(), $id);
        if (! $article ) {
            throw new HttpException(404, "Not found article.");
        } else {
            $article->setPublished(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
        }
        return $this->redirectToRoute('edit_list');
    }


}
