<?php

namespace App\Controller;

use App\Http\Request;
use App\Repositories\GalleryItemRepository;
use App\Repositories\PageRepository;

class GalleryController extends AbstractController
{
    public function __construct(
        private readonly GalleryItemRepository $galleryRepository = new GalleryItemRepository(),
        private readonly PageRepository $pageRepository = new PageRepository()
    ) {
    }

    public function index(Request $request): string
    {
        $page = $this->pageRepository->findBySlug('gallery');
        $items = $this->galleryRepository->all();

        return $this->render('gallery.php', [
            'page' => $page,
            'items' => $items,
        ]);
    }
}
