<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AirqualitySensor
 *
 * @ORM\Table(name="Airquality_Sensor", indexes={@ORM\Index(name="fk_Airquality_Sensor_Sensor_Info1", columns={"SSN"})})
 * @ORM\Entity
 */
class AirqualitySensor
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
     * @ORM\Column(name="CO", type="float", precision=10, scale=0, nullable=false)
     */
    private $co;

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
     * @var float
     *
     * @ORM\Column(name="NO2", type="float", precision=10, scale=0, nullable=false)
     */
    private $no2;

    /**
     * @var float
     *
     * @ORM\Column(name="O3", type="float", precision=10, scale=0, nullable=false)
     */
    private $o3;

    /**
     * @var float
     *
     * @ORM\Column(name="PM10", type="float", precision=10, scale=0, nullable=false)
     */
    private $pm10;

    /**
     * @var float
     *
     * @ORM\Column(name="PM2.5", type="float", precision=10, scale=0, nullable=false)
     */
    private $pm2.5;

    /**
     * @var float
     *
     * @ORM\Column(name="SO2", type="float", precision=10, scale=0, nullable=false)
     */
    private $so2;

    /**
     * @var float
     *
     * @ORM\Column(name="temperature", type="float", precision=10, scale=0, nullable=false)
     */
    private $temperature;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=false)
     */
    private $timestamp;

    /**
     * @var \SensorInfo
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="SensorInfo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SSN", referencedColumnName="SSN")
     * })
     */
    private $ssn;


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return AirqualitySensor
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
     * Set co
     *
     * @param float $co
     *
     * @return AirqualitySensor
     */
    public function setCo($co)
    {
        $this->co = $co;

        return $this;
    }

    /**
     * Get co
     *
     * @return float
     */
    public function getCo()
    {
        return $this->co;
    }

    /**
     * Set lat
     *
     * @param float $lat
     *
     * @return AirqualitySensor
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
     * @return AirqualitySensor
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
     * Set no2
     *
     * @param float $no2
     *
     * @return AirqualitySensor
     */
    public function setNo2($no2)
    {
        $this->no2 = $no2;

        return $this;
    }

    /**
     * Get no2
     *
     * @return float
     */
    public function getNo2()
    {
        return $this->no2;
    }

    /**
     * Set o3
     *
     * @param float $o3
     *
     * @return AirqualitySensor
     */
    public function setO3($o3)
    {
        $this->o3 = $o3;

        return $this;
    }

    /**
     * Get o3
     *
     * @return float
     */
    public function getO3()
    {
        return $this->o3;
    }

    /**
     * Set pm10
     *
     * @param float $pm10
     *
     * @return AirqualitySensor
     */
    public function setPm10($pm10)
    {
        $this->pm10 = $pm10;

        return $this;
    }

    /**
     * Get pm10
     *
     * @return float
     */
    public function getPm10()
    {
        return $this->pm10;
    }

    /**
     * Set pm2.5
     *
     * @param float $pm2.5
     *
     * @return AirqualitySensor
     */
    public function setPm2.5($pm2.5)
    {
        $this->pm2.5 = $pm2.5;

        return $this;
    }

    /**
     * Get pm2.5
     *
     * @return float
     */
    public function getPm2.5()
    {
        return $this->pm2.5;
    }

    /**
     * Set so2
     *
     * @param float $so2
     *
     * @return AirqualitySensor
     */
    public function setSo2($so2)
    {
        $this->so2 = $so2;

        return $this;
    }

    /**
     * Get so2
     *
     * @return float
     */
    public function getSo2()
    {
        return $this->so2;
    }

    /**
     * Set temperature
     *
     * @param float $temperature
     *
     * @return AirqualitySensor
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Get temperature
     *
     * @return float
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return AirqualitySensor
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
     * Set ssn
     *
     * @param \SensorInfo $ssn
     *
     * @return AirqualitySensor
     */
    public function setSsn(\SensorInfo $ssn)
    {
        $this->ssn = $ssn;

        return $this;
    }

    /**
     * Get ssn
     *
     * @return \SensorInfo
     */
    public function getSsn()
    {
        return $this->ssn;
    }
}

