<?php 

class Fire_department extends CI_Model {

    private $mongoCollection = 'incidents';
    private $configNS = 'fd';

    protected $where = array();
    protected $offset = 0;
    protected $limit = 15;

    function __construct()
    {
        parent::__construct();
    }

    /*
     * Fire_department::totalIncidents
     *
     * Produces a count of the total number of incidents.
     *
     * @return integer The number of total incidents.
     */
    public function totalIncidents() {
       // return $this->mongo_db->count($this->mongoCollection);
        return $this->mongo_db->where($this->where)->count($this->mongoCollection);
    }

    /*
     * Fire_department::cityCode
     *
     * Adds a regex where clause operator to the mongo query which specifies
     * cities from which to draw incident results.
     *
     * @param string $cityCode The two-letter city code to filter by.
     * @return object Returns itself so that the method can be chained.
     */
    public function cityCode($cityCode) {
        
        // Verify that the $cityCode is in our config list of codes
        if(!empty($cityCode) && in_array($cityCode, $this->config->item('cityCodes', $this->configNS))) {
            $regexObj = new MongoRegex("/, " . $cityCode . "/");
            $this->where['prime_street'] = $regexObj;
        }
        else {
            // Or, if the code is empty, clear this clause.
            if(isset($this->where['cityCode'])) {
                unset($this->where['cityCode']);
            }
        }

        return $this;
    }
    
    public function incidentType($incidentType) {
        if(!empty($incidentType)) {
            $this->where['incident_type'] = $incidentType;
        }
        else {
            // Or, if the code is empty, clear this clause.
            if(isset($this->where['incident_type'])) {
                unset($this->where['incident_type']);
            }
        }

        return $this;
    }

    /*
     * Fire_department::offset
     *
     * Used for pagination of the result set. Offset is how far into the total
     * set we want to begin returning results.
     *
     * @param integer $offset How far into the set we want results to start.
     * @return object Returns itself so that the method can be chained.
     */
    public function offset($offset) {
        if(!empty($offset)) {
            $this->offset = intval($offset);
        }

        return $this;
    }

    /*
     * Fire_department::getOffset
     *
     * Returns the current offset value.
     *
     * @return integer The current offset value
     */
    public function getOffset() {
        return $this->offset;
    }

    /*
     * Fire_department::limit
     *
     * Used for pagination of the result set. Limit defines how many records
     * should be returned.
     *
     * @param integer $limit How many records we want returned
     * @return object Returns itself so that the method can be chained.
     */
    public function limit($limit) {
        if(!empty($limit)) {
            $this->limit = intval($limit);
        }

        return $this;
    }

    /*
     * Fire_department::getLimit
     *
     * Returns the current limit value.
     *
     * @return integer The current limit value
     */
    public function getLimit() {
        return $this->limit;
    }

    /*
     * Fire_department::getIncidents
     *
     * Collects a set of incident records using the stored clause operators and
     * returns it to the caller.
     *
     * @return array A set of mongo records based on the stored operators.
     */
    public function getIncidents() {       
        return $this->mongo_db->where($this->where)->offset($this->offset)->limit($this->limit)->get($this->mongoCollection);
    }

    /*
     * Fire_department::getIncidentTypes
     *
     * Returns a list of incident types pulled directly from the database.
     *
     * @return array A set of mongo records based on the stored operators.
     */
    public function getIncidentTypes() {
        return $this->mongo_db->command(array('distinct' => $this->mongoCollection, 'key' => 'incident_type'));
    }
}
