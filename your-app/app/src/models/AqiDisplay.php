<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AqiDisplay
 *
 * @ORM\Table(name="AQI_display", indexes={@ORM\Index(name="fk_AQI_display_User_app1_idx", columns={"USN"})})
 * @ORM\Entity
 */
class AqiDisplay
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
     * @ORM\Column(name="AQI_CO2", type="float", precision=10, scale=0, nullable=false)
     */
    private $aqiCo2;

    /**
     * @var float
     *
     * @ORM\Column(name="AQI_NO2", type="float", precision=10, scale=0, nullable=false)
     */
    private $aqiNo2;

    /**
     * @var float
     *
     * @ORM\Column(name="AQI_O3", type="float", precision=10, scale=0, nullable=false)
     */
    private $aqiO3;

    /**
     * @var float
     *
     * @ORM\Column(name="AQI_PM10", type="float", precision=10, scale=0, nullable=false)
     */
    private $aqiPm10;

    /**
     * @var float
     *
     * @ORM\Column(name="AQI_PM2.5", type="float", precision=10, scale=0, nullable=false)
     */
    private $aqiPm2.5;

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
     * @ORM\Column(name="lnt", type="float", precision=10, scale=0, nullable=false)
     */
    private $lnt;

    /**
     * @var integer
     *
     * @ORM\Column(name="SSN", type="integer", nullable=false)
     */
    private $ssn;

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
     * @return AqiDisplay
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
     * Set aqiCo2
     *
     * @param float $aqiCo2
     *
     * @return AqiDisplay
     */
    public function setAqiCo2($aqiCo2)
    {
        $this->aqiCo2 = $aqiCo2;

        return $this;
    }

    /**
     * Get aqiCo2
     *
     * @return float
     */
    public function getAqiCo2()
    {
        return $this->aqiCo2;
    }

    /**
     * Set aqiNo2
     *
     * @param float $aqiNo2
     *
     * @return AqiDisplay
     */
    public function setAqiNo2($aqiNo2)
    {
        $this->aqiNo2 = $aqiNo2;

        return $this;
    }

    /**
     * Get aqiNo2
     *
     * @return float
     */
    public function getAqiNo2()
    {
        return $this->aqiNo2;
    }

    /**
     * Set aqiO3
     *
     * @param float $aqiO3
     *
     * @return AqiDisplay
     */
    public function setAqiO3($aqiO3)
    {
        $this->aqiO3 = $aqiO3;

        return $this;
    }

    /**
     * Get aqiO3
     *
     * @return float
     */
    public function getAqiO3()
    {
        return $this->aqiO3;
    }

    /**
     * Set aqiPm10
     *
     * @param float $aqiPm10
     *
     * @return AqiDisplay
     */
    public function setAqiPm10($aqiPm10)
    {
        $this->aqiPm10 = $aqiPm10;

        return $this;
    }

    /**
     * Get aqiPm10
     *
     * @return float
     */
    public function getAqiPm10()
    {
        return $this->aqiPm10;
    }

    /**
     * Set aqiPm2.5
     *
     * @param float $aqiPm2.5
     *
     * @return AqiDisplay
     */
    public function setAqiPm2.5($aqiPm2.5)
    {
        $this->aqiPm2.5 = $aqiPm2.5;

        return $this;
    }

    /**
     * Get aqiPm2.5
     *
     * @return float
     */
    public function getAqiPm2.5()
    {
        return $this->aqiPm2.5;
    }

    /**
     * Set heartRate
     *
     * @param float $heartRate
     *
     * @return AqiDisplay
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
     * @return AqiDisplay
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
     * Set lnt
     *
     * @param float $lnt
     *
     * @return AqiDisplay
     */
    public function setLnt($lnt)
    {
        $this->lnt = $lnt;

        return $this;
    }

    /**
     * Get lnt
     *
     * @return float
     */
    public function getLnt()
    {
        return $this->lnt;
    }

    /**
     * Set ssn
     *
     * @param integer $ssn
     *
     * @return AqiDisplay
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
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return AqiDisplay
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
     * @return AqiDisplay
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

