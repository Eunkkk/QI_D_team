<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * TempUser
 *
 * @ORM\Table(name="Temp_user")
 * @ORM\Entity
 */
class TempUser
{
    /**
     * @var string
     *
     * @ORM\Column(name="e_mail", type="string", length=45, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $eMail;

    /**
     * @var string
     *
     * @ORM\Column(name="auth_code", type="string", length=128, nullable=false)
     */
    private $authCode;

    /**
     * @var string
     *
     * @ORM\Column(name="birth_date", type="string", length=10, nullable=false)
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=40, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="hashed_pwd", type="string", length=128, nullable=false)
     */
    private $hashedPwd;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=40, nullable=false)
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=false)
     */
    private $timestamp;


    /**
     * Get eMail
     *
     * @return string
     */
    public function getEMail()
    {
        return $this->eMail;
    }

    /**
     * Set authCode
     *
     * @param string $authCode
     *
     * @return TempUser
     */
    public function setAuthCode($authCode)
    {
        $this->authCode = $authCode;

        return $this;
    }

    /**
     * Get authCode
     *
     * @return string
     */
    public function getAuthCode()
    {
        return $this->authCode;
    }

    /**
     * Set birthDate
     *
     * @param string $birthDate
     *
     * @return TempUser
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return TempUser
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set hashedPwd
     *
     * @param string $hashedPwd
     *
     * @return TempUser
     */
    public function setHashedPwd($hashedPwd)
    {
        $this->hashedPwd = $hashedPwd;

        return $this;
    }

    /**
     * Get hashedPwd
     *
     * @return string
     */
    public function getHashedPwd()
    {
        return $this->hashedPwd;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return TempUser
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return TempUser
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}

