<?php

namespace App\Controller;

use App\Http\Request;
use App\Repositories\ContactInfoRepository;
use App\Repositories\EventRepository;
use App\Repositories\GalleryItemRepository;
use App\Repositories\PageRepository;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly EventRepository $eventRepository = new EventRepository(),
        private readonly GalleryItemRepository $galleryRepository = new GalleryItemRepository(),
        private readonly PageRepository $pageRepository = new PageRepository(),
        private readonly ContactInfoRepository $contactInfoRepository = new ContactInfoRepository()
    ) {
    }

    public function index(Request $request): string
    {
        $home = $this->pageRepository->findBySlug('home');
        $events = $this->eventRepository->upcoming();
        $gallery = $this->galleryRepository->all();
        $contactInfo = $this->contactInfoRepository->get();
        $reservationSuccess = (string) $request->query('reservation') === '1';

        return $this->render('home.php', [
            'page' => $home,
            'events' => $events,
            'gallery' => $gallery,
            'contactInfo' => $contactInfo,
            'reservationSuccess' => $reservationSuccess,
        ]);
    }
}
