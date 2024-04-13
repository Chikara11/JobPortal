<?php

class Job
{
    private $id;
    private $companyName;
    private $title;
    private $function;
    private $location;
    private $seniorityLevel;
    private $description;
    private $positionDate;
    public $jobType;
    private $industry;
    private $experience;
    private $degree;
    private $salary;
    private $recruiterId;
    private $recruiterName;
    private $status;

    // Constructor to initialize the object with values
    function __construct(

        $companyName,
        $title,
        $function,
        $location,
        $seniorityLevel,
        $description,
        $positionDate,
        $jobType,
        $industry,
        $experience,
        $degree,
        $salary,
        $recruiterId,
        $recruiterName,
        $status,
        $id
    ) {
        // Assign the provided values to the corresponding properties
        $this->companyName = $companyName;
        $this->title = $title;
        $this->function = $function;
        $this->location = $location;
        $this->seniorityLevel = $seniorityLevel;
        $this->description = $description;
        $this->positionDate = $positionDate;
        $this->jobType = $jobType;
        $this->industry = $industry;
        $this->experience = $experience;
        $this->degree = $degree;
        $this->salary = $salary;
        $this->recruiterId = $recruiterId;
        $this->recruiterName = $recruiterName;
        $this->status = $status;
        $this->id = $id;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getCompanyName()
    {
        return $this->companyName;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getFunction()
    {
        return $this->function;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getSeniorityLevel()
    {
        return $this->seniorityLevel;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPositionDate()
    {
        return $this->positionDate;
    }

    public function getJobType()
    {
        return $this->jobType;
    }

    public function getIndustry()
    {
        return $this->industry;
    }

    public function getExperience()
    {
        return $this->experience;
    }

    public function getDegree()
    {
        return $this->degree;
    }

    public function getSalary()
    {
        return $this->salary;
    }

    public function getRecruiterId()
    {
        return $this->recruiterId;
    }

    public function getRecruiterName()
    {
        return $this->recruiterName;
    }

    public function getStatus()
    {
        return $this->status;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setFunction($function)
    {
        $this->function = $function;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function setSeniorityLevel($seniorityLevel)
    {
        $this->seniorityLevel = $seniorityLevel;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setPositionDate($positionDate)
    {
        $this->positionDate = $positionDate;
    }

    public function setJobType($jobType)
    {
        $this->jobType = $jobType;
    }

    public function setIndustry($industry)
    {
        $this->industry = $industry;
    }

    public function setExperience($experience)
    {
        $this->experience = $experience;
    }

    public function setDegree($degree)
    {
        $this->degree = $degree;
    }

    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    public function setRecruiterId($recruiterId)
    {
        $this->recruiterId = $recruiterId;
    }

    public function setRecruiterName($recruiterName)
    {
        $this->recruiterName = $recruiterName;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }


}