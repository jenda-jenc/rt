<?php

namespace App\Controller;

use App\Http\Request;
use App\Repositories\ContactRepository;
use App\Security\CsrfTokenManager;

class ReportController extends AbstractController
{
    public function __construct(private readonly ContactRepository $contactRepository = new ContactRepository())
    {
    }

    public function submit(Request $request): string
    {
        if ($request->getMethod() !== 'POST') {
            http_response_code(405);
            return 'Metoda není podporována';
        }

        if (!CsrfTokenManager::validateToken($request->request('_csrf'))) {
            http_response_code(400);
            return 'Neplatný CSRF token';
        }

        $data = [
            'name' => trim((string) $request->request('name')),
            'email' => trim((string) $request->request('email')),
            'message' => trim((string) $request->request('message')),
        ];

        if ($data['name'] === '' || $data['email'] === '' || $data['message'] === '') {
            http_response_code(422);
            return 'Vyplňte prosím všechna pole.';
        }

        $this->contactRepository->create($data);

        header('Location: /?submitted=1');
        return '';
    }
}
