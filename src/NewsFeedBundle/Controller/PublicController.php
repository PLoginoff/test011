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
        if (empty($article)) {
            throw new HttpException(404, "Article not found.");
        }
        return $this->render(
            'NewsFeedBundle:Public:view.html.twig',
            [
            'article' => $article
            ]
        );
    }

    /**
     * @Route("/pdf/{id}", requirements={"id" = "\d+"}, name="public_pdf")
     */
    public function pdfAction($id)
    {
        $repo    = $this->getDoctrine()->getRepository('NewsFeedBundle:Article');
        $article = $repo->getPublicOne($id);
        if (empty($article)) {
            throw new HttpException(404, "Article not found.");
        }
        
        $html = $this->render(
            'NewsFeedBundle:Public:pdf.html.twig',
            [
            'article' => $article
            ]
        );

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html->getContent());
        $dompdf->render();
        $pdfoutput = $dompdf->output();

        return new Response(
            $pdfoutput,
            200,
            ['Content-Type' => 'application/pdf']
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

        return $this->render(
            'NewsFeedBundle:Public:news.html.twig',
            [
            'list' => $list
            ]
        );
    }

    /**
     * @Route("/feed", name="public_feed")
     */
    public function feedAction()
    {
        $repo = $this->getDoctrine()->getRepository('NewsFeedBundle:Article');
        $list = $repo->getPublicList();

        $rss = $this->render(
            'NewsFeedBundle:Public:rss.xml.twig',
            [
            'list' => $list
            ]
        );

        return new Response(
            $rss->getContent(),
            200,
            ['Content-Type' => 'application/rss+xml; charset=utf-8']
        );
    }
}
