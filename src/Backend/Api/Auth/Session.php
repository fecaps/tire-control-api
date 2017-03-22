<?php
declare(strict_types=1);

namespace Backend\Api\Auth;

use Backend\Api\Model\AuthSession;
use DateTime;

class Session
{
    const EXPIRE_TOKEN_WINDOW = '+10 days';

    private $model;

    public function __construct(AuthSession $model)
    {
        $this->model = $model;
    }

    public function create($userId): array
    {
        $token      = base64_encode(uniqid($userId, true));
        $userIp     = $_SERVER['REMOTE_ADDR'] ?? [];
        $createAt   = new DateTime;
        $expireAt   = clone $createAt;
        $expireAt->modify(self::EXPIRE_TOKEN_WINDOW);
    
        $sessionData = [
            'token'         => $token,
            'created_at'    => $createAt->format('Y-m-d H:i:s'),
            'expire_at'     => $expireAt->format('Y-m-d H:i:s'),
            'user_id'       => $userId,
            'user_ip'       => $userIp
        ];

        $this->model->create($sessionData);

        return $sessionData;
    }
}
