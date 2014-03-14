<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{

        // Get the incident Types
        $incidentTypes = $this->fire_department->getIncidentTypes();

        // Get the total results, count, then trim based on filters and get the count again.
        $totalIncidents = $this->fire_department->totalIncidents();
        $matchingIncidents = $this->fire_department
            ->cityCode($this->input->get('cc'))
            ->incidentType($this->input->get('it'))
            ->offset($this->input->get('p'))
            ->limit($this->input->get('pp'))
            ->getIncidents();
        $totalMatchingIncidents = $this->fire_department->totalIncidents();

        //Configure the pagination based on the results and init
        $paginationCfg['total_rows'] = $totalMatchingIncidents;
        $paginationCfg['per_page'] = $this->fire_department->getLimit();
        $this->pagination->initialize($paginationCfg);

        // Start formatting the table
        $this->table->set_heading(array(
            'incident #', 
            'type', 
            'cross street', 
            'alarm_level', 
            'prime street',
            'area', 
            'units dispatched', 
            'time'    
        )); 
        
        $this->table->set_template(array(
            'table_open' => '<table class="table table-striped table-bordered table-hover table-condensed">'
        ));

        // Circle through the incidents and format them into table rows.
        $incidentHTML = array();
        foreach($matchingIncidents as $incident) {
            unset($incident['_id']);
            $incidentHTML['incident_id'] = $incident['incident_id'];
            $incidentHTML['incident_type'] = $incident['incident_type'];
            $incidentHTML['cross_street'] = $incident['cross_street'];
            $incidentHTML['alarm_level'] = '<span class="badge">' . $incident['alarm_level'] . '</span>';
            $incidentHTML['prime_street'] = $incident['prime_street'];
            $incidentHTML['area'] = '<span class="label label-info">' . $incident['area'] . '</span>';
            $incidentHTML['dispatched_units'] = $incident['dispatched_units'];
            $incidentHTML['dispatch_time'] = $incident['dispatch_time'];

            $this->table->add_row(array_values($incidentHTML));
        }

        //Collect data for the main view
        $data = array (
            'incidentTypes'         => $incidentTypes,
            'paginationHTML'        => $this->pagination->create_links(),
            'selectedIncidents'     => $totalMatchingIncidents,
            'totalIncidents'        => $totalIncidents,
            'incidents'             => $matchingIncidents,
            'incidentsTable'        => $this->table->generate()
        );

        $this->load->view('layout/main', array(
            'pageHeader' => 'Archive',
            'docContent' => $this->load->view('home', $data, TRUE),
            'sidebarContent' => $this->load->view('sidebar/main',array(),TRUE))
        );
    }   
}
