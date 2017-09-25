<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Books
 *
 * @ORM\Table(name="books")
 * @ORM\Entity
 */
class Books
{
    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="text", nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="Author", type="text", nullable=true)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="Year", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="Numeric", type="text", nullable=true)
     */
    private $numeric;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

