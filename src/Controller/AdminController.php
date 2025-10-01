<?php

namespace App\Controller;

use App\Http\Request;
use App\Repositories\AdminUserRepository;
use App\Repositories\ContactRepository;
use App\Repositories\EventRepository;
use App\Repositories\GalleryItemRepository;
use App\Repositories\PageRepository;
use App\Security\CsrfTokenManager;

class AdminController extends AbstractController
{
    private const SESSION_AUTH_KEY = '_admin_user';

    public function __construct(
        private readonly AdminUserRepository $userRepository = new AdminUserRepository(),
        private readonly EventRepository $eventRepository = new EventRepository(),
        private readonly GalleryItemRepository $galleryRepository = new GalleryItemRepository(),
        private readonly ContactRepository $contactRepository = new ContactRepository(),
        private readonly PageRepository $pageRepository = new PageRepository()
    ) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function login(Request $request): string
    {
        if ($this->isAuthenticated()) {
            header('Location: /admin');
            return '';
        }

        if ($request->getMethod() === 'POST') {
            if (!CsrfTokenManager::validateToken($request->request('_csrf'))) {
                $error = 'Neplatný CSRF token.';
            } else {
                $username = (string) $request->request('username');
                $password = (string) $request->request('password');
                $user = $this->userRepository->findByUsername($username);
                if ($user && password_verify($password, $user['password_hash'])) {
                    $_SESSION[self::SESSION_AUTH_KEY] = $user['username'];
                    header('Location: /admin');
                    return '';
                }
                $error = 'Přihlášení se nezdařilo.';
            }
        }

        $csrf = CsrfTokenManager::getToken();

        return $this->render('admin/login.php', [
            'csrf' => $csrf,
            'error' => $error ?? null,
        ], 'admin/layout.php');
    }

    public function logout(Request $request): string
    {
        unset($_SESSION[self::SESSION_AUTH_KEY]);
        header('Location: /admin/login');
        return '';
    }

    public function dashboard(Request $request): string
    {
        $this->assertAuthenticated();

        $events = $this->eventRepository->all();
        $galleryItems = $this->galleryRepository->all();
        $pages = $this->pageRepository->all();

        $eventToEdit = null;
        $galleryToEdit = null;
        $pageToEdit = null;

        if ($eventId = (int) $request->query('event')) {
            $eventToEdit = $this->eventRepository->find($eventId);
        }

        if ($galleryId = (int) $request->query('gallery')) {
            $galleryToEdit = $this->galleryRepository->find($galleryId);
        }

        if ($pageSlug = trim((string) $request->query('page'))) {
            $pageToEdit = $this->pageRepository->findBySlug($pageSlug);
        }

        return $this->render('admin/dashboard.php', [
            'events' => $events,
            'galleryItems' => $galleryItems,
            'contacts' => $this->contactRepository->all(),
            'pages' => $pages,
            'eventToEdit' => $eventToEdit,
            'galleryToEdit' => $galleryToEdit,
            'pageToEdit' => $pageToEdit,
            'csrf' => CsrfTokenManager::getToken(),
        ], 'admin/layout.php');
    }

    public function saveEvent(Request $request): string
    {
        $this->assertAuthenticated();
        $this->guardCsrf($request);

        $data = $request->allPost();
        $this->eventRepository->save([
            'id' => $data['id'] ?? null,
            'title' => trim((string) ($data['title'] ?? '')),
            'description' => trim((string) ($data['description'] ?? '')) ?: null,
            'event_date' => $data['event_date'] ?? date('Y-m-d'),
            'starts_at' => $data['starts_at'] ?? null,
            'price' => trim((string) ($data['price'] ?? '')) ?: null,
        ]);

        header('Location: /admin');
        return '';
    }

    public function deleteEvent(Request $request): string
    {
        $this->assertAuthenticated();
        $this->guardCsrf($request);

        $id = (int) $request->request('id');
        if ($id > 0) {
            $this->eventRepository->delete($id);
        }

        header('Location: /admin');
        return '';
    }

    public function saveGalleryItem(Request $request): string
    {
        $this->assertAuthenticated();
        $this->guardCsrf($request);

        $data = $request->allPost();
        $this->galleryRepository->save([
            'id' => $data['id'] ?? null,
            'title' => trim((string) ($data['title'] ?? '')) ?: null,
            'image_path' => trim((string) ($data['image_path'] ?? '')),
            'description' => trim((string) ($data['description'] ?? '')) ?: null,
            'position' => (int) ($data['position'] ?? 0),
        ]);

        header('Location: /admin');
        return '';
    }

    public function deleteGalleryItem(Request $request): string
    {
        $this->assertAuthenticated();
        $this->guardCsrf($request);

        $id = (int) $request->request('id');
        if ($id > 0) {
            $this->galleryRepository->delete($id);
        }

        header('Location: /admin');
        return '';
    }

    public function deleteContact(Request $request): string
    {
        $this->assertAuthenticated();
        $this->guardCsrf($request);

        $id = (int) $request->request('id');
        if ($id > 0) {
            $this->contactRepository->delete($id);
        }

        header('Location: /admin');
        return '';
    }

    public function savePage(Request $request): string
    {
        $this->assertAuthenticated();
        $this->guardCsrf($request);

        $data = $request->allPost();
        $this->pageRepository->save([
            'id' => $data['id'] ?? null,
            'slug' => trim((string) ($data['slug'] ?? '')),
            'title' => trim((string) ($data['title'] ?? '')),
            'content' => trim((string) ($data['content'] ?? '')),
        ]);

        header('Location: /admin');
        return '';
    }

    private function guardCsrf(Request $request): void
    {
        if (!CsrfTokenManager::validateToken($request->request('_csrf'))) {
            http_response_code(400);
            exit('Neplatný CSRF token.');
        }
    }

    private function isAuthenticated(): bool
    {
        return !empty($_SESSION[self::SESSION_AUTH_KEY]);
    }

    private function assertAuthenticated(): void
    {
        if (!$this->isAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }
    }
}
