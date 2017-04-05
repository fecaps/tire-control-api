<?php
declare(strict_types=1);

namespace Api\Controller;

use Symfony\Component\HttpFoundation\Request;
use Api\Model\User;

class UserController
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function signup(Request $request): array
    {
        $data = $request->request->all();

        $user = $this->user->create($data);

        $returnData = [
            'name'     => $user['name'],
            'email'    => $user['email'],
            'username' => $user['username']
        ];

        return $returnData;
    }
}
