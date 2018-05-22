<?php

namespace Bundles\UserBundle\Entity;

/**
 * Info
 */
class Info
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $currentSummary;

    /**
     * @var string
     */
    private $currentPosition;

    /**
     * @var string
     */
    private $department;

    /**
     * @var string
     */
    private $skills;

    /**
     * @var string
     */
    private $education;

    /**
     * @var string
     */
    private $lang;

    /**
     * @var string
     */
    private $interests;

    /**
     * @var string
     */
    private $localResp;

    /**
     * @var string
     */
    private $organisation;

    /**
     * @var string
     */
    private $orgType;

    /**
     * @var string
     */
    private $orgSize;

    /**
     * @var string
     */
    private $summary;

    /**
     * @var string
     */
    private $businessArea;

    /**
     * @var string
     */
    private $clients;

    /**
     * @var string
     */
    private $purchaseArea;

    /**
     * @var string
     */
    private $clubs;

    /**
     * @var string
     */
    private $interestedIn;

    /**
     * @var string
     */
    private $twitter;

    /**
     * @var string
     */
    private $youtube;

    /**
     * @var string
     */
    private $facebook;

    /**
     * @var string
     */
    private $website;

    /**
     * @var string
     */
    private $docs;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set currentSummary
     *
     * @param string $currentSummary
     *
     * @return Info
     */
    public function setCurrentSummary($currentSummary)
    {
        $this->currentSummary = $currentSummary;

        return $this;
    }

    /**
     * Get currentSummary
     *
     * @return string
     */
    public function getCurrentSummary()
    {
        return $this->currentSummary;
    }

    /**
     * Set currentPosition
     *
     * @param string $currentPosition
     *
     * @return Info
     */
    public function setCurrentPosition($currentPosition)
    {
        $this->currentPosition = $currentPosition;

        return $this;
    }

    /**
     * Get currentPosition
     *
     * @return string
     */
    public function getCurrentPosition()
    {
        return $this->currentPosition;
    }

    /**
     * Set department
     *
     * @param string $department
     *
     * @return Info
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set skills
     *
     * @param string $skills
     *
     * @return Info
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * Get skills
     *
     * @return string
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Set education
     *
     * @param string $education
     *
     * @return Info
     */
    public function setEducation($education)
    {
        $this->education = $education;

        return $this;
    }

    /**
     * Get education
     *
     * @return string
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Set lang
     *
     * @param string $lang
     *
     * @return Info
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set interests
     *
     * @param string $interests
     *
     * @return Info
     */
    public function setInterests($interests)
    {
        $this->interests = $interests;

        return $this;
    }

    /**
     * Get interests
     *
     * @return string
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * Set localResp
     *
     * @param string $localResp
     *
     * @return Info
     */
    public function setLocalResp($localResp)
    {
        $this->localResp = $localResp;

        return $this;
    }

    /**
     * Get localResp
     *
     * @return string
     */
    public function getLocalResp()
    {
        return $this->localResp;
    }

    /**
     * Set organisation
     *
     * @param string $organisation
     *
     * @return Info
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;

        return $this;
    }

    /**
     * Get organisation
     *
     * @return string
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * Set orgType
     *
     * @param string $orgType
     *
     * @return Info
     */
    public function setOrgType($orgType)
    {
        $this->orgType = $orgType;

        return $this;
    }

    /**
     * Get orgType
     *
     * @return string
     */
    public function getOrgType()
    {
        return $this->orgType;
    }

    /**
     * Set orgSize
     *
     * @param string $orgSize
     *
     * @return Info
     */
    public function setOrgSize($orgSize)
    {
        $this->orgSize = $orgSize;

        return $this;
    }

    /**
     * Get orgSize
     *
     * @return string
     */
    public function getOrgSize()
    {
        return $this->orgSize;
    }

    /**
     * Set summary
     *
     * @param string $summary
     *
     * @return Info
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set businessArea
     *
     * @param string $businessArea
     *
     * @return Info
     */
    public function setBusinessArea($businessArea)
    {
        $this->businessArea = $businessArea;

        return $this;
    }

    /**
     * Get businessArea
     *
     * @return string
     */
    public function getBusinessArea()
    {
        return $this->businessArea;
    }

    /**
     * Set clients
     *
     * @param string $clients
     *
     * @return Info
     */
    public function setClients($clients)
    {
        $this->clients = $clients;

        return $this;
    }

    /**
     * Get clients
     *
     * @return string
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * Set purchaseArea
     *
     * @param string $purchaseArea
     *
     * @return Info
     */
    public function setPurchaseArea($purchaseArea)
    {
        $this->purchaseArea = $purchaseArea;

        return $this;
    }

    /**
     * Get purchaseArea
     *
     * @return string
     */
    public function getPurchaseArea()
    {
        return $this->purchaseArea;
    }

    /**
     * Set clubs
     *
     * @param string $clubs
     *
     * @return Info
     */
    public function setClubs($clubs)
    {
        $this->clubs = $clubs;

        return $this;
    }

    /**
     * Get clubs
     *
     * @return string
     */
    public function getClubs()
    {
        return $this->clubs;
    }

    /**
     * Set interestedIn
     *
     * @param string $interestedIn
     *
     * @return Info
     */
    public function setInterestedIn($interestedIn)
    {
        $this->interestedIn = $interestedIn;

        return $this;
    }

    /**
     * Get interestedIn
     *
     * @return string
     */
    public function getInterestedIn()
    {
        return $this->interestedIn;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return Info
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set youtube
     *
     * @param string $youtube
     *
     * @return Info
     */
    public function setYoutube($youtube)
    {
        $this->youtube = $youtube;

        return $this;
    }

    /**
     * Get youtube
     *
     * @return string
     */
    public function getYoutube()
    {
        return $this->youtube;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return Info
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Info
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set docs
     *
     * @param string $docs
     *
     * @return Info
     */
    public function setDocs($docs)
    {
        $this->docs = $docs;

        return $this;
    }

    /**
     * Get docs
     *
     * @return string
     */
    public function getDocs()
    {
        return $this->docs;
    }
    /**
     * @var string
     */
    private $email;


    /**
     * Set email
     *
     * @param string $email
     *
     * @return Info
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @var string
     */
    private $overview;


    /**
     * Set overview
     *
     * @param string $overview
     *
     * @return Info
     */
    public function setOverview($overview)
    {
        $this->overview = $overview;

        return $this;
    }

    /**
     * Get overview
     *
     * @return string
     */
    public function getOverview()
    {
        return $this->overview;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->skills = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add skill
     *
     * @param \Bundles\OptionBundle\Entity\Skill $skill
     *
     * @return Info
     */
    public function addSkill(\Bundles\OptionBundle\Entity\Skill $skill)
    {
        $this->skills[] = $skill;

        return $this;
    }

    /**
     * Remove skill
     *
     * @param \Bundles\OptionBundle\Entity\Skill $skill
     */
    public function removeSkill(\Bundles\OptionBundle\Entity\Skill $skill)
    {
        $this->skills->removeElement($skill);
    }
    
    public function removeAllSkills()
    {
       $this->skills->clear();
    }
    
    public function removeAllLangs()
    {
       $this->lang->clear();
    }

    /**
     * Add lang
     *
     * @param \Bundles\OptionBundle\Entity\Language $lang
     *
     * @return Info
     */
    public function addLang(\Bundles\OptionBundle\Entity\Language $lang)
    {
        $this->lang[] = $lang;

        return $this;
    }

    /**
     * Remove lang
     *
     * @param \Bundles\OptionBundle\Entity\Language $lang
     */
    public function removeLang(\Bundles\OptionBundle\Entity\Language $lang)
    {
        $this->lang->removeElement($lang);
    }
}
