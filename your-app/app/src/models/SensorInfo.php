<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SensorInfo
 *
 * @ORM\Table(name="Sensor_Info", indexes={@ORM\Index(name="fk_Sensor_Info_User_app1_idx", columns={"USN"})})
 * @ORM\Entity
 */
class SensorInfo
{
    /**
     * @var string
     *
     * @ORM\Column(name="mac_address", type="string", length=12, nullable=false)
     */
    private $macAddress;

    /**
     * @var boolean
     *
     * @ORM\Column(name="regActive", type="boolean", nullable=true)
     */
    private $regactive;

    /**
     * @var string
     *
     * @ORM\Column(name="sensor_name", type="string", length=45, nullable=true)
     */
    private $sensorName;

    /**
     * @var integer
     *
     * @ORM\Column(name="SSN", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ssn;

    /**
     * @var string
     *
     * @ORM\Column(name="support_service", type="string", length=45, nullable=true)
     */
    private $supportService;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=true)
     */
    private $timestamp;

    /**
     * @var \UserApp
     *
     * @ORM\ManyToOne(targetEntity="UserApp")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="USN", referencedColumnName="USN")
     * })
     */
    private $usn;


    /**
     * Set macAddress
     *
     * @param string $macAddress
     *
     * @return SensorInfo
     */
    public function setMacAddress($macAddress)
    {
        $this->macAddress = $macAddress;

        return $this;
    }

    /**
     * Get macAddress
     *
     * @return string
     */
    public function getMacAddress()
    {
        return $this->macAddress;
    }

    /**
     * Set regactive
     *
     * @param boolean $regactive
     *
     * @return SensorInfo
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
     * Set sensorName
     *
     * @param string $sensorName
     *
     * @return SensorInfo
     */
    public function setSensorName($sensorName)
    {
        $this->sensorName = $sensorName;

        return $this;
    }

    /**
     * Get sensorName
     *
     * @return string
     */
    public function getSensorName()
    {
        return $this->sensorName;
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
     * Set supportService
     *
     * @param string $supportService
     *
     * @return SensorInfo
     */
    public function setSupportService($supportService)
    {
        $this->supportService = $supportService;

        return $this;
    }

    /**
     * Get supportService
     *
     * @return string
     */
    public function getSupportService()
    {
        return $this->supportService;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return SensorInfo
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
     * Set usn
     *
     * @param \UserApp $usn
     *
     * @return SensorInfo
     */
    public function setUsn(\UserApp $usn = null)
    {
        $this->usn = $usn;

        return $this;
    }

    /**
     * Get usn
     *
     * @return \UserApp
     */
    public function getUsn()
    {
        return $this->usn;
    }
}

