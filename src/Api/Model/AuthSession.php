<?php
declare(strict_types=1);

namespace Api\Model;

use Api\Validator\AuthSession as AuthSessionValidator;
use Api\Repository\AuthSession as AuthSessionRepository;
use DateTime;

/**
 * @Entity @Table(name="auth_session")
 **/
class AuthSession
{
    /**
     * @Id
     * @Column(type="string", length=255)
     */
    private $token;

    /**
     * Many AuthSession has One User.
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @Column(type="datetime", nullable=false)
     */
    private $created_at;

    /**
     * @Column(type="datetime", nullable=false)
     */
    private $expire_at;

    /**
     * @Column(type="string", length=200, nullable=false)
     */
    private $user_ip;

    private $validator;

    private $repository;

    public function __construct(AuthSessionValidator $validator, AuthSessionRepository $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function create(array $sessionData)
    {
        $this->validator->validate($sessionData);

        $this->repository->create($sessionData);
    }

    public function update($token, array $data)
    {
        $criteria = ['token' => $token];

        $this->repository->update($data, $criteria);
    }

    public function check($token)
    {
        $session = $this->repository->findByToken($token);

        if (!$session) {
            return false;
        }

        $currentDate = new Datetime();

        $expireAtDate = new Datetime($session['expire_at']);

        return $currentDate < $expireAtDate;
    }
}
