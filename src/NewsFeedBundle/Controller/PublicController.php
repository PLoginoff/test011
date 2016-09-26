<?php

namespace NewsFeedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Response;


class PublicController extends Controller
{
    /**
     * @Route("/view/{id}", requirements={"id" = "\d+"}, name="public_view")
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
     * @Route("/pdf/{id}", requirements={"id" = "\d+"}, name="public_pdf")
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
        $pdfoutput = $dompdf->output();

        //$dompdf->stream('newsfeed_' . $article->getId() . '.pdf');
        return new Response(
            $pdfoutput,
            200,
            array('Content-Type' => 'application/pdf')
        );
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

    /**
     * @Route("/feed", name="public_feed")
     */
    public function feedAction()
    {
        $repo = $this->getDoctrine()->getRepository('NewsFeedBundle:Article');
        $list = $repo->getPublicList();

        // FIXME
        header('Content-Type: application/rss+xml; charset=utf-8');

        return $this->render('NewsFeedBundle:Public:rss.xml.twig', array(
            'list' => $list
        ));
    }

}
