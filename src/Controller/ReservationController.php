<?php

namespace App\Controller;

use App\Http\Request;
use App\Repositories\ReservationRepository;
use App\Security\CsrfTokenManager;

class ReservationController extends AbstractController
{
    public function __construct(private readonly ReservationRepository $reservationRepository = new ReservationRepository())
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
            'phone' => trim((string) $request->request('phone')),
            'event_date' => trim((string) $request->request('event_date')),
            'message' => trim((string) $request->request('message')),
        ];

        if ($data['name'] === '' || $data['email'] === '' || $data['message'] === '') {
            http_response_code(422);
            return 'Vyplňte prosím jméno, e-mail a detaily akce.';
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(422);
            return 'Zadejte platný e-mail.';
        }

        $eventDate = $data['event_date'] !== '' ? $data['event_date'] : null;
        if ($eventDate !== null && !preg_match('/^\\d{4}-\\d{2}-\\d{2}$/', $eventDate)) {
            http_response_code(422);
            return 'Datum musí být ve formátu RRRR-MM-DD.';
        }

        $this->reservationRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?: null,
            'event_date' => $eventDate,
            'message' => $data['message'],
        ]);

        header('Location: /?reservation=1');
        return '';
    }
}
