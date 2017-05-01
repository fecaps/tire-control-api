<?php
declare(strict_types=1);

namespace Api\Auth;

use Api\Model\AuthSession;
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
        $userId     = (string) $userId;
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

    public function expire($token)
    {
        $date = new DateTime();
        
        $date->modify('-1 second');

        $data = ['expire_at' => $date->format('Y-m-d H:i:s')];

        $this->model->update($token, $data);
    }

    public function renew($token)
    {
        $date = new DateTime();

        $date->modify(self::EXPIRE_TOKEN_WINDOW);

        $data = ['expire_at' => $date->format('Y-m-d H:i:s')];

        $this->model->update($token, $data);
    }
}
