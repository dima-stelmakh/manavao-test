<?php

namespace Bundles\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

class User extends BaseUser
{
    use \Bundles\StoreBundle\Component\City;
    use \Bundles\ImageBundle\Model\Imageable;
    
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->setCity('Toulouse');
        $this->setCreatedAt(new \Datetime);
        // your own logic
    }
    
    public function setEmail($email)
    {
        $this->setUsername($email);

        return parent::setEmail($email);
    }

    public function removeAllInterestedIn()
    {
       $this->interestedIn->clear();
    }

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $job;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sharedPosts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $posts;

    /**
     * @var \Bundles\OptionBundle\Entity\Industry
     */
    private $industry;

    /**
     * @var \Bundles\StoreBundle\Entity\Country
     */
    private $country;

    /**
     * @var \Bundles\StoreBundle\Entity\UrbanArea
     */
    private $urbanArea;

    /**
     * @var \Bundles\OptionBundle\Entity\Category
     */
    private $category;

    /**
     * @var \Bundles\OptionBundle\Entity\Zone
     */
    private $zone;

    /**
     * @var \Bundles\OptionBundle\Entity\AuthorType
     */
    private $type;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $communities;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $interestedIn;


    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set job
     *
     * @param string $job
     *
     * @return User
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add sharedPost
     *
     * @param \Bundles\StoreBundle\Entity\SharePost $sharedPost
     *
     * @return User
     */
    public function addSharedPost(\Bundles\StoreBundle\Entity\SharePost $sharedPost)
    {
        $this->sharedPosts[] = $sharedPost;

        return $this;
    }

    /**
     * Remove sharedPost
     *
     * @param \Bundles\StoreBundle\Entity\SharePost $sharedPost
     */
    public function removeSharedPost(\Bundles\StoreBundle\Entity\SharePost $sharedPost)
    {
        $this->sharedPosts->removeElement($sharedPost);
    }

    /**
     * Get sharedPosts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSharedPosts()
    {
        return $this->sharedPosts;
    }

    /**
     * Add post
     *
     * @param \Bundles\StoreBundle\Entity\Post $post
     *
     * @return User
     */
    public function addPost(\Bundles\StoreBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \Bundles\StoreBundle\Entity\Post $post
     */
    public function removePost(\Bundles\StoreBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set industry
     *
     * @param \Bundles\OptionBundle\Entity\Industry $industry
     *
     * @return User
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
     * Set country
     *
     * @param \Bundles\StoreBundle\Entity\Country $country
     *
     * @return User
     */
    public function setCountry(\Bundles\StoreBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Bundles\StoreBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set urbanArea
     *
     * @param \Bundles\StoreBundle\Entity\UrbanArea $urbanArea
     *
     * @return User
     */
    public function setUrbanArea(\Bundles\StoreBundle\Entity\UrbanArea $urbanArea = null)
    {
        $this->urbanArea = $urbanArea;

        return $this;
    }

    /**
     * Get urbanArea
     *
     * @return \Bundles\StoreBundle\Entity\UrbanArea
     */
    public function getUrbanArea()
    {
        return $this->urbanArea;
    }

    /**
     * Set category
     *
     * @param \Bundles\OptionBundle\Entity\Category $category
     *
     * @return User
     */
    public function setCategory(\Bundles\OptionBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Bundles\OptionBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set zone
     *
     * @param \Bundles\OptionBundle\Entity\Zone $zone
     *
     * @return User
     */
    public function setZone(\Bundles\OptionBundle\Entity\Zone $zone = null)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return \Bundles\OptionBundle\Entity\Zone
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Set type
     *
     * @param \Bundles\OptionBundle\Entity\AuthorType $type
     *
     * @return User
     */
    public function setType(\Bundles\OptionBundle\Entity\AuthorType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Bundles\OptionBundle\Entity\AuthorType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add community
     *
     * @param \Bundles\StoreBundle\Entity\Community $community
     *
     * @return User
     */
    public function addCommunity(\Bundles\StoreBundle\Entity\Community $community)
    {
        $this->communities[] = $community;

        return $this;
    }

    /**
     * Remove community
     *
     * @param \Bundles\StoreBundle\Entity\Community $community
     */
    public function removeCommunity(\Bundles\StoreBundle\Entity\Community $community)
    {
        $this->communities->removeElement($community);
    }

    /**
     * Get communities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommunities()
    {
        return $this->communities;
    }

    /**
     * Add interestedIn
     *
     * @param \Bundles\OptionBundle\Entity\InterestedIn $interestedIn
     *
     * @return User
     */
    public function addInterestedIn(\Bundles\OptionBundle\Entity\InterestedIn $interestedIn)
    {
        $this->interestedIn[] = $interestedIn;

        return $this;
    }

    /**
     * Remove interestedIn
     *
     * @param \Bundles\OptionBundle\Entity\InterestedIn $interestedIn
     */
    public function removeInterestedIn(\Bundles\OptionBundle\Entity\InterestedIn $interestedIn)
    {
        $this->interestedIn->removeElement($interestedIn);
    }

    /**
     * Get interestedIn
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInterestedIn()
    {
        return $this->interestedIn;
    }

    /**
     * @var \Bundles\UserBundle\Entity\Info
     */
    private $inform;


    /**
     * Set inform
     *
     * @param \Bundles\UserBundle\Entity\Info $inform
     *
     * @return User
     */
    public function setInform(\Bundles\UserBundle\Entity\Info $inform = null)
    {
        $this->inform = $inform;

        return $this;
    }

    /**
     * Get inform
     *
     * @return \Bundles\UserBundle\Entity\Info
     */
    public function getInform()
    {
        return $this->inform;
    }
    /**
     * @var string
     */
    private $linkedIn;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $IM;


    /**
     * Set linkedIn
     *
     * @param string $linkedIn
     *
     * @return User
     */
    public function setLinkedIn($linkedIn)
    {
        $this->linkedIn = $linkedIn;

        return $this;
    }

    /**
     * Get linkedIn
     *
     * @return string
     */
    public function getLinkedIn()
    {
        return $this->linkedIn;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set iM
     *
     * @param string $iM
     *
     * @return User
     */
    public function setIM($iM)
    {
        $this->IM = $iM;

        return $this;
    }

    /**
     * Get iM
     *
     * @return string
     */
    public function getIM()
    {
        return $this->IM;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $likePosts;


    /**
     * Add likePost
     *
     * @param \Bundles\StoreBundle\Entity\LikePost $likePost
     *
     * @return User
     */
    public function addLikePost(\Bundles\StoreBundle\Entity\LikePost $likePost)
    {
        $this->likePosts[] = $likePost;

        return $this;
    }

    /**
     * Remove likePost
     *
     * @param \Bundles\StoreBundle\Entity\LikePost $likePost
     */
    public function removeLikePost(\Bundles\StoreBundle\Entity\LikePost $likePost)
    {
        $this->likePosts->removeElement($likePost);
    }

    /**
     * Get likePosts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLikePosts()
    {
        return $this->likePosts;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $friendUsers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $friends;


    /**
     * Add friendUser
     *
     * @param \Bundles\StoreBundle\Entity\Friend $friendUser
     *
     * @return User
     */
    public function addFriendUser(\Bundles\StoreBundle\Entity\Friend $friendUser)
    {
        $this->friendUsers[] = $friendUser;

        return $this;
    }

    /**
     * Remove friendUser
     *
     * @param \Bundles\StoreBundle\Entity\Friend $friendUser
     */
    public function removeFriendUser(\Bundles\StoreBundle\Entity\Friend $friendUser)
    {
        $this->friendUsers->removeElement($friendUser);
    }

    /**
     * Get friendUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriendUsers()
    {
        return $this->friendUsers;
    }

    /**
     * Add friend
     *
     * @param \Bundles\StoreBundle\Entity\Friend $friend
     *
     * @return User
     */
    public function addFriend(\Bundles\StoreBundle\Entity\Friend $friend)
    {
        $this->friends[] = $friend;

        return $this;
    }

    /**
     * Remove friend
     *
     * @param \Bundles\StoreBundle\Entity\Friend $friend
     */
    public function removeFriend(\Bundles\StoreBundle\Entity\Friend $friend)
    {
        $this->friends->removeElement($friend);
    }

    /**
     * Get friends
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriends()
    {
        return $this->friends;
    }
}
