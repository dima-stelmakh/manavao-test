<?php

namespace Bundles\StoreBundle\Entity;

/**
 * OpportunityPost
 */
class OpportunityPost
{
    /**
     * @var int
     */
    private $id;


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
     * @var \Bundles\StoreBundle\Entity\Post
     */
    private $post;


    /**
     * Set post
     *
     * @param \Bundles\StoreBundle\Entity\Post $post
     *
     * @return OpportunityPost
     */
    public function setPost(\Bundles\StoreBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \Bundles\StoreBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @var string
     */
    private $fewWords;

    /**
     * @var \DateTime
     */
    private $deadline;

    /**
     * @var boolean
     */
    private $isMyNameConfidential;

    /**
     * @var boolean
     */
    private $showToEveryone;

    /**
     * @var boolean
     */
    private $readyToContact;

    /**
     * @var \Bundles\OptionBundle\Entity\AuthorType
     */
    private $authorType;

    /**
     * @var \Bundles\OptionBundle\Entity\Industry
     */
    private $industry;


    /**
     * Set fewWords
     *
     * @param string $fewWords
     *
     * @return OpportunityPost
     */
    public function setFewWords($fewWords)
    {
        $this->fewWords = $fewWords;

        return $this;
    }

    /**
     * Get fewWords
     *
     * @return string
     */
    public function getFewWords()
    {
        return $this->fewWords;
    }

    /**
     * Set deadline
     *
     * @param \DateTime $deadline
     *
     * @return OpportunityPost
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline
     *
     * @return \DateTime
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

   

    /**
     * Set isMyNameConfidential
     *
     * @param boolean $isMyNameConfidential
     *
     * @return OpportunityPost
     */
    public function setIsMyNameConfidential($isMyNameConfidential)
    {
        $this->isMyNameConfidential = $isMyNameConfidential;

        return $this;
    }

    /**
     * Get isMyNameConfidential
     *
     * @return boolean
     */
    public function getIsMyNameConfidential()
    {
        return $this->isMyNameConfidential;
    }

    /**
     * Set showToEveryone
     *
     * @param boolean $showToEveryone
     *
     * @return OpportunityPost
     */
    public function setShowToEveryone($showToEveryone)
    {
        $this->showToEveryone = $showToEveryone;

        return $this;
    }

    /**
     * Get showToEveryone
     *
     * @return boolean
     */
    public function getShowToEveryone()
    {
        return $this->showToEveryone;
    }

    /**
     * Set readyToContact
     *
     * @param boolean $readyToContact
     *
     * @return OpportunityPost
     */
    public function setReadyToContact($readyToContact)
    {
        $this->readyToContact = $readyToContact;

        return $this;
    }

    /**
     * Get readyToContact
     *
     * @return boolean
     */
    public function getReadyToContact()
    {
        return $this->readyToContact;
    }

    /**
     * Set authorType
     *
     * @param \Bundles\OptionBundle\Entity\AuthorType $authorType
     *
     * @return OpportunityPost
     */
    public function setAuthorType(\Bundles\OptionBundle\Entity\AuthorType $authorType = null)
    {
        $this->authorType = $authorType;

        return $this;
    }

    /**
     * Get authorType
     *
     * @return \Bundles\OptionBundle\Entity\AuthorType
     */
    public function getAuthorType()
    {
        return $this->authorType;
    }

    /**
     * Set industry
     *
     * @param \Bundles\OptionBundle\Entity\Industry $industry
     *
     * @return OpportunityPost
     */
    public function setIndustry(\Bundles\OptionBundle\Entity\Industry $industry = null)
    {
        $this->industry = $industry;

        return $this;
    }

    /**
     * Get industry
     *
     * @return \Bundles\OptionBundle\Entity\Industry
     */
    public function getIndustry()
    {
        return $this->industry;
    }
    /**
     * @var \Bundles\OptionBundle\Entity\ProjectType
     */
    private $projectType;

//    /**
//     * @var \Bundles\OptionBundle\Entity\Skill
//     */
//    private $skill;


    /**
     * Set projectType
     *
     * @param \Bundles\OptionBundle\Entity\ProjectType $projectType
     *
     * @return OpportunityPost
     */
    public function setProjectType(\Bundles\OptionBundle\Entity\ProjectType $projectType = null)
    {
        $this->projectType = $projectType;

        return $this;
    }

    /**
     * Get projectType
     *
     * @return \Bundles\OptionBundle\Entity\ProjectType
     */
    public function getProjectType()
    {
        return $this->projectType;
    }
//
//    /**
//     * Set skill
//     *
//     * @param \Bundles\OptionBundle\Entity\Skill $skill
//     *
//     * @return OpportunityPost
//     */
//    public function setSkill(\Bundles\OptionBundle\Entity\Skill $skill = null)
//    {
//        $this->skill = $skill;
//
//        return $this;
//    }
//
//    /**
//     * Get skill
//     *
//     * @return \Bundles\OptionBundle\Entity\Skill
//     */
//    public function getSkill()
//    {
//        return $this->skill;
//    }
    /**
     * @var string
     */
    private $skill;


    /**
     * Set skill
     *
     * @param string $skill
     *
     * @return OpportunityPost
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return string
     */
    public function getSkill()
    {
        return $this->skill;
    }
}
