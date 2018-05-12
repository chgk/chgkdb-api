<?php

namespace APP\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * People
 *
 * @ORM\Table(name="People", uniqueConstraints={@ORM\UniqueConstraint(name="CharId", columns={"CharId"})})
 * @ORM\Entity
 */
class People
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CharId", type="string", length=20, nullable=true, options={"fixed"=true})
     */
    private $charid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Name", type="string", length=50, nullable=true, options={"fixed"=true})
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Surname", type="string", length=50, nullable=true, options={"fixed"=true})
     */
    private $surname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="City", type="string", length=50, nullable=true, options={"fixed"=true})
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nicks", type="text", length=65535, nullable=true)
     */
    private $nicks;

    /**
     * @var int|null
     *
     * @ORM\Column(name="QNumber", type="integer", nullable=true)
     */
    private $qnumber = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="TNumber", type="integer", nullable=true)
     */
    private $tnumber = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="RatingId", type="integer", nullable=true)
     */
    private $ratingid = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="IsCertifiedEditor", type="boolean", nullable=true)
     */
    private $iscertifiededitor = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="IsCertifiedReferee", type="boolean", nullable=true)
     */
    private $iscertifiedreferee = '0';


}
