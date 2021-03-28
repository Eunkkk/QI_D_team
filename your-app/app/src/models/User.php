<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="User")
 * @ORM\Entity
 */
class User
{
    /**
     * @var string
     *
     * @ORM\Column(name="auth_code", type="string", length=128, nullable=true)
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
     * @ORM\Column(name="e_mail", type="string", length=45, nullable=false)
     */
    private $eMail;

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
     * @var boolean
     *
     * @ORM\Column(name="loginStateFlag", type="boolean", nullable=false)
     */
    private $loginstateflag;

    /**
     * @var boolean
     *
     * @ORM\Column(name="permission", type="boolean", nullable=false)
     */
    private $permission;

    /**
     * @var boolean
     *
     * @ORM\Column(name="regActive", type="boolean", nullable=false)
     */
    private $regactive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=true)
     */
    private $timestamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="USN", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $usn;


    /**
     * Set authCode
     *
     * @param string $authCode
     *
     * @return User
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
     * @return User
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
     * Set eMail
     *
     * @param string $eMail
     *
     * @return User
     */
    public function setEMail($eMail)
    {
        $this->eMail = $eMail;

        return $this;
    }

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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
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
     * @return User
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
     * @return User
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
     * Set loginstateflag
     *
     * @param boolean $loginstateflag
     *
     * @return User
     */
    public function setLoginstateflag($loginstateflag)
    {
        $this->loginstateflag = $loginstateflag;

        return $this;
    }

    /**
     * Get loginstateflag
     *
     * @return boolean
     */
    public function getLoginstateflag()
    {
        return $this->loginstateflag;
    }

    /**
     * Set permission
     *
     * @param boolean $permission
     *
     * @return User
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get permission
     *
     * @return boolean
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set regactive
     *
     * @param boolean $regactive
     *
     * @return User
     */
    public function setRegactive($regactive)
    {
        $this->regactive = $regactive;

        return $this;
    }

    /**
     * Get regactive
     *
     * @return boolean
     */
    public function getRegactive()
    {
        return $this->regactive;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return User
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

    /**
     * Get usn
     *
     * @return integer
     */
    public function getUsn()
    {
        return $this->usn;
    }
}

