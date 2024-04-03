<?php
class User
{
    private $id;
    private $fullname;
    private $email;
    private $password;
    private $verifyToken;
    private $verifyStatus; // Updated to camelCase
    private $phone_num; // Updated to camelCase
    protected $userType;

    private $ProfilePic;

    // Employer attributes
    private $companyName;
    private $industry;
    private $website;
    private $companySize;

    // Employee attributes
    private $about;
    private $education;
    private $school;
    private $skills;
    private $jobTitle;
    private $Country;
    private $City;

    public function __construct(
        $fullname = "",
        $email = "",
        $password = "",
        $phoneNum = null,
        $verifyToken = "",
        $userType = "",
        $id = null,
        $verifyStatus = 0,
        $companyName = "",
        $industry = "",
        $website = "",
        $companySize = "",
        $about = "",
        $education = "",
        $school = "",
        $skills = "",
        $jobTitle = "",
        $ProfilePic = "",
        $Country = "",
        $City = ""
    ) {
        $this->fullname = $fullname;
        $this->email = $email;
        $this->password = $password;
        $this->phoneNum = $phoneNum;
        $this->verifyToken = $verifyToken;
        $this->userType = $userType;
        $this->id = $id;
        $this->verifyStatus = $verifyStatus;
        $this->companyName = $companyName;
        $this->industry = $industry;
        $this->website = $website;
        $this->companySize = $companySize;
        $this->about = $about;
        $this->education = $education;
        $this->school = $school;
        $this->skills = $skills;
        $this->jobTitle = $jobTitle;
        $this->ProfilePic = $ProfilePic;
        $this->Country = $Country;
        $this->City = $City;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getVerifyToken()
    {
        return $this->verifyToken;
    }

    public function getPhoneNum()
    {
        return $this->phone_num;
    }

    public function getVerifyStatus()
    {
        return $this->verifyStatus;
    }

    public function getProfilePic()
    {
        return $this->ProfilePic;
    }

    public function getCountry()
    {
        return $this->Country;
    }

    public function getCity()
    {
        return $this->City;
    }


    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function setVerifyToken($verifyToken)
    {
        $this->verifyToken = $verifyToken;
    }

    public function setPhoneNum($phone_num)
    {
        $this->phone_num = $phone_num;
    }

    public function setVerifyStatus($verifyStatus)
    {
        $this->verifyStatus = $verifyStatus;
    }

    public function getUserType()
    {
        return $this->userType;
    }

    public function setUserType($userType)
    {
        $this->userType = $userType;
    }
    public function getCompanyName()
    {
        return $this->companyName;
    }

    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    public function getIndustry()
    {
        return $this->industry;
    }

    public function setIndustry($industry)
    {
        $this->industry = $industry;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function setWebsite($website)
    {
        $this->website = $website;
    }

    public function getCompanySize()
    {
        return $this->companySize;
    }

    public function setCompanySize($companySize)
    {
        $this->companySize = $companySize;
    }

    public function getAbout()
    {
        return $this->about;
    }

    public function setAbout($about)
    {
        $this->about = $about;
    }

    public function getEducation()
    {
        return $this->education;
    }

    public function setEducation($education)
    {
        $this->education = $education;
    }

    public function getSchool()
    {
        return $this->school;
    }

    public function setSchool($school)
    {
        $this->school = $school;
    }

    public function getSkills()
    {
        return $this->skills;
    }

    public function setSkills($skills)
    {
        $this->skills = $skills;
    }

    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;
    }

    public function setCounry($setCounry)
    {
        $this->setCounry = $setCounry;
    }

    public function setCity($City)
    {
        $this->City = $City;
    }


}