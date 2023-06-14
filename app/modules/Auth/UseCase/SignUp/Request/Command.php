<?php

declare(strict_types=1);

namespace Modules\Auth\UseCase\SignUp\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @Assert\Email()
     */
    public string $email;
    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @Assert\Length(min=6)
     */
    public string $password;

    /**
     * @param string $email
     * @return Command
     */
    public function setEmail(string $email): Command
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $password
     * @return Command
     */
    public function setPassword(string $password): Command
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
