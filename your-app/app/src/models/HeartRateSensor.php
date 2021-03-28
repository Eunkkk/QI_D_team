<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * HeartRateSensor
 *
 * @ORM\Table(name="Heart-Rate Sensor", indexes={@ORM\Index(name="fk_Heart-Rate Sensor_User_app1", columns={"USN"})})
 * @ORM\Entity
 */
class HeartRateSensor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="heart_rate", type="float", precision=10, scale=0, nullable=false)
     */
    private $heartRate;

    /**
     * @var float
     *
     * @ORM\Column(name="lat", type="float", precision=10, scale=0, nullable=false)
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(name="lng", type="float", precision=10, scale=0, nullable=false)
     */
    private $lng;

    /**
     * @var integer
     *
     * @ORM\Column(name="RR_interval", type="integer", nullable=false)
     */
    private $rrInterval;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=false)
     */
    private $timestamp;

    /**
     * @var \UserApp
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="UserApp")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="USN", referencedColumnName="USN")
     * })
     */
    private $usn;


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return HeartRateSensor
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set heartRate
     *
     * @param float $heartRate
     *
     * @return HeartRateSensor
     */
    public function setHeartRate($heartRate)
    {
        $this->heartRate = $heartRate;

        return $this;
    }

    /**
     * Get heartRate
     *
     * @return float
     */
    public function getHeartRate()
    {
        return $this->heartRate;
    }

    /**
     * Set lat
     *
     * @param float $lat
     *
     * @return HeartRateSensor
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param float $lng
     *
     * @return HeartRateSensor
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set rrInterval
     *
     * @param integer $rrInterval
     *
     * @return HeartRateSensor
     */
    public function setRrInterval($rrInterval)
    {
        $this->rrInterval = $rrInterval;

        return $this;
    }

    /**
     * Get rrInterval
     *
     * @return integer
     */
    public function getRrInterval()
    {
        return $this->rrInterval;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return HeartRateSensor
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
     * @return HeartRateSensor
     */
    public function setUsn(\UserApp $usn)
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

