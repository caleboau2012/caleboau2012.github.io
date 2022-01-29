<?php

class PharmacistController{
    private $pharmacy;

    public function __construct(){
        $this->pharmacy = new PharmacistModel();
    }

    public function addDrugUnits($unitSymbolArray){
        return $this->pharmacy->addDrugUnits($unitSymbolArray);
    }

    public function removeDrugUnit($unitRefId){
        return $this->pharmacy->removeDrugUnit($unitRefId);
    }

    public function getUnits(){
        return $this->pharmacy->getUnits();
    }

    public function getPatientQueue(){
        return $this->pharmacy->getPatientQueue(DRUG_UNCLEARED);
    }

    public function getPrescription($treatmentId, $encounterId){
        return $this->pharmacy->getPrescription($treatmentId, $encounterId);
    }

    public function AddPrescription ($somepre, $treatment_id, $status, $mod, $encounter_id = 0){
            return $this->pharmacy->AddPrescription($somepre, $treatment_id, $status, $mod, $encounter_id);
    }

    public function clearPrescription($pharmacist_id, $data){
        return $this->pharmacy->clearPrescription($pharmacist_id, $data);
    }

    public function addDrug($drug){
        return $this->pharmacy->addDrug($drug);
    }

    public function getDrugs(){
        return $this->pharmacy->getDrugs();
    }

    public function isInPatient($patientId){
        return $this->pharmacy->isInPatient($patientId);
    }

    public function isOutPatient($patientId){
        return $this->pharmacy->isOutPatient($patientId);
    }

}