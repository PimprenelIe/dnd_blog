<?php


namespace App\Controller;

use App\Entity\Page\Page;
use App\Form\ContactType;
use App\Repository\Page\PageRepository;
use App\Service\HtmlFunctions;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class PageController extends AbstractController
{

    public const FROM_MAIL = "no-reply@uddc.com";
    public const TO_MAIL = "no-reply@uddc.com";

    #[Route('/contact', name: 'contact', options: ['sitemap' => ['section' => 'site']])]
    public function pageContact(
        Request $request,
        PageRepository $pageRepository,
        MailerInterface $mailer,
        LoggerInterface $logger
    ): Response
    {

        $page = $pageRepository->findOneBy(['type' => Page::TYPE_CONTACT]);


        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $spamDetected = false;
            $data = $form->getData();
            if ($_SERVER["HTTP_HOST"] !== "localhost") {
                foreach ($data as $key => $value) {
                    if (!is_array($value) && !is_object($value)) {
                        if (HtmlFunctions::detectTags($value)) {
                            $spamDetected = true;
                            $this->addFlash(
                                'error',
                                "Erreur : vous utilisez des balises ou des liens. Ce n'est pas autorisé."
                            );
                        }
                    }
                }
                if ($data['test1'] !== $data['test2']
                    || !empty($data['email'])
                    || $_SERVER['HTTP_REFERER'] != $this->generateUrl('contact', [], UrlGeneratorInterface::ABSOLUTE_URL)) {
                    $spamDetected = true;
                    $this->addFlash(
                        'error',
                        "Erreur : vous devez activer Javascript."
                    );
                }
            }

            if (!$spamDetected) {
                $date = new \DateTime('now');

                $renderMail = $this->renderView(
                // templates/emails/registration.html.twig
                    'mail/contact.html.twig',
                    [
                        'message' => $data['message'],
                        'email' => $data['information'],

                    ]
                );

                $email = (new Email())
                    ->subject('[' . date_format($date, 'd/m/Y H:i') . '] Contact')
                    ->from(self::FROM_MAIL)
                    ->to(self::TO_MAIL)
                    ->html($renderMail);

                try {
                    $mailer->send($email);
                    $this->addFlash(
                        'success',
                        'Votre message a bien été envoyé !'
                    );
                    $form = $this->createForm(ContactType::class);
                } catch (\Throwable $e) {
                    $logger->critical(__CLASS__.'::'.__FUNCTION__.'() - '. $e->getMessage());
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue.'
                    );
                }

            }
        }

        return $this->render('page/contact.html.twig', [
            'page' => $page,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{slug}', name: 'page_show', priority: -1)]
    public function page(
        Page $page
    ): Response
    {

        if ($page->getType() !== Page::TYPE_SIMPLE) {
            return $this->redirectToRoute('home');
        }

        return $this->render('page/show.html.twig', [
            'page' => $page
        ]);
    }


}