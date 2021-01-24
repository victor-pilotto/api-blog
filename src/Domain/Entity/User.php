<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\DisplayName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Image;
use App\Domain\ValueObject\Password;
use App\Domain\ValueObject\UserId;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(
     *     name="id",
     *     type="App\Domain\ValueObject\UserId"
     * )
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private UserId $id;

    /**
     * @ORM\Column(
     *     name="displayName",
     *     type="App\Domain\ValueObject\DisplayName"
     * )
     */
    private DisplayName $displayName;

    /**
     * @ORM\Column(
     *     name="email",
     *     type="App\Domain\ValueObject\Email"
     * )
     */
    private Email $email;

    /**
     * @ORM\Column(
     *     name="password",
     *     type="App\Domain\ValueObject\Password"
     * )
     */
    private Password $password;

    /**
     * @ORM\Column(
     *     name="image",
     *     type="App\Domain\ValueObject\Image"
     * )
     */
    private ?Image $image;

    /** @ORM\OneToMany(targetEntity="Post", mappedBy="user", cascade={"persist", "remove"}) */
    private Collection $posts;

    private function __construct()
    {
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function displayName(): DisplayName
    {
        return $this->displayName;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function image(): Image
    {
        return $this->image;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id()->value(),
            'displayName' => $this->displayName()->toString(),
            'email' => $this->email()->toString(),
            'image' => $this->image()->toString()
        ];
    }

    public static function novo(
        DisplayName $displayName,
        Email $email,
        Password $password,
        ?Image $image
    ): self {
        $instance = new self();

        $instance->displayName = $displayName;
        $instance->email       = $email;
        $instance->password    = $password;
        $instance->image       = $image;

        return $instance;
    }
}
