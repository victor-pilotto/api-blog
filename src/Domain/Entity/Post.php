<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Content;
use App\Domain\ValueObject\PostId;
use App\Domain\ValueObject\Published;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Updated;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Posts")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\Column(
     *     name="id",
     *     type="App\Domain\ValueObject\PostId"
     * )
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private PostId $id;

    /**
     * @ORM\Column(
     *     name="title",
     *     type="App\Domain\ValueObject\Title"
     * )
     */
    private Title $title;

    /**
     * @ORM\Column(
     *     name="content",
     *     type="App\Domain\ValueObject\Content"
     * )
     */
    private Content $content;

    /**
     * @ORM\Column(
     *     name="published",
     *     type="App\Domain\ValueObject\Published"
     * )
     */
    private Published $published;

    /**
     * @ORM\Column(
     *     name="updated",
     *     type="App\Domain\ValueObject\Updated"
     * )
     */
    private ?Updated $updated;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private User $user;
}
