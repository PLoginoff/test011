<?php

namespace NewsFeedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Dompdf\Dompdf;

class PublicController extends Controller
{
    /**
     * @Route("/view/{id}", requirements={"id" = "\d+"})
     */
    public function viewAction($id)
    {
        $repo    = $this->getDoctrine()->getRepository('NewsFeedBundle:Article');
        $article = $repo->getPublicOne($id);
        if ( empty($article) ) {
            throw new HttpException(404, "Article not found.");
        }
        return $this->render('NewsFeedBundle:Public:view.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/pdf/{id}", requirements={"id" = "\d+"})
     */
    public function pdfAction($id)
    {
        $repo    = $this->getDoctrine()->getRepository('NewsFeedBundle:Article');
        $article = $repo->getPublicOne($id);
        if ( empty($article) ) {
            throw new HttpException(404, "Article not found.");
        }
        $html = $this->render('NewsFeedBundle:Public:pdf.html.twig', [
            'article' => $article
        ]);

        // FIXME set filentame!
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html->getContent());
        $dompdf->render();
        $dompdf->stream();
    }

    /**
     * @Route("/news", name="public_news")
     * @Route("/")
     */
    public function newsAction()
    {
        $repo = $this->getDoctrine()->getRepository('NewsFeedBundle:Article');
        $list = $repo->getPublicList();

        return $this->render('NewsFeedBundle:Public:news.html.twig', array(
            'list' => $list
        ));
    }

}
