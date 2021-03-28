<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * UserApp
 *
 * @ORM\Table(name="User_app")
 * @ORM\Entity
 */
class UserApp
{
    /**
     * @var integer
     *
     * @ORM\Column(name="SSN", type="integer", nullable=false)
     */
    private $ssn;

    /**
     * @var \User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="USN", referencedColumnName="USN")
     * })
     */
    private $usn;


    /**
     * Set ssn
     *
     * @param integer $ssn
     *
     * @return UserApp
     */
    public function setSsn($ssn)
    {
        $this->ssn = $ssn;

        return $this;
    }

    /**
     * Get ssn
     *
     * @return integer
     */
    public function getSsn()
    {
        return $this->ssn;
    }

    /**
     * Set usn
     *
     * @param \User $usn
     *
     * @return UserApp
     */
    public function setUsn(\User $usn)
    {
        $this->usn = $usn;

        return $this;
    }

    /**
     * Get usn
     *
     * @return \User
     */
    public function getUsn()
    {
        return $this->usn;
    }
}

