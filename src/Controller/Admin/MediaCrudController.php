<?php

namespace App\Controller\Admin;

use App\Entity\Media\Media;
use App\Field\VichImageField;
use App\Repository\Media\MediaRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MediaCrudController extends AbstractCrudController
{
    /**
     * @var MediaRepository
     */
    private MediaRepository $mediaRepository;

    public function __construct(
        MediaRepository $mediaRepository
    )
    {
        $this->mediaRepository = $mediaRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Media::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel(false)->addCssClass('col-xl-4'),
            VichImageField::new('fileName')->hideOnForm(),
            VichImageField::new('file')->onlyOnForms(),

            FormField::addPanel(false)->addCssClass('col-xl-8'),
            TextField::new('title'),
            TextField::new('legend'),
            TextField::new('alt'),
            TextField::new('fileName')->onlyOnIndex(),
            TextField::new('originalName')->hideOnIndex()->setDisabled(),
            TextField::new('mimeType')->hideOnIndex()->setDisabled(),
            AssociationField::new('posts', 'Dans article')->hideOnForm()
        ];
    }


    /**
     * @Route("/admin/autocomplete-media-picker", name="admin_autocomplete_media_picker")
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteMediaPicker(Request $request): JsonResponse
    {

        $search = $request->query->get('search');
        $data = $this->mediaRepository->findAutocompleteMediaPicker($search);

        return new JsonResponse($data);
    }
}