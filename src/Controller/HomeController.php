<?php

namespace App\Controller;

use App\Http\Request;
use App\Repositories\EventRepository;
use App\Repositories\GalleryItemRepository;
use App\Repositories\PageRepository;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly EventRepository $eventRepository = new EventRepository(),
        private readonly GalleryItemRepository $galleryRepository = new GalleryItemRepository(),
        private readonly PageRepository $pageRepository = new PageRepository()
    ) {
    }

    public function index(Request $request): string
    {
        $home = $this->pageRepository->findBySlug('home');
        $events = $this->eventRepository->upcoming();
        $gallery = $this->galleryRepository->all();

        return $this->render('home.php', [
            'page' => $home,
            'events' => $events,
            'gallery' => $gallery,
        ]);
    }
}
