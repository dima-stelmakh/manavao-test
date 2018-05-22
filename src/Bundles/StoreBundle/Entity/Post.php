<?php

namespace Bundles\StoreBundle\Entity;

use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Post
 */
class Post
{
    use ORMBehaviors\Timestampable\Timestampable;
    
    const TYPE_UPDATE = 1;
    const TYPE_OPPORTUNITY = 2;
    const TYPE_EVENT = 3;
        
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $content;


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
     * Set content
     *
     * @param string $content
     *
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sharedUsers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $likes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sharedUsers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->likes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add sharedUser
     *
     * @param \Bundles\StoreBundle\Entity\SharePost $sharedUser
     *
     * @return Post
     */
    public function addSharedUser(\Bundles\StoreBundle\Entity\SharePost $sharedUser)
    {
        $this->sharedUsers[] = $sharedUser;

        return $this;
    }

    /**
     * Remove sharedUser
     *
     * @param \Bundles\StoreBundle\Entity\SharePost $sharedUser
     */
    public function removeSharedUser(\Bundles\StoreBundle\Entity\SharePost $sharedUser)
    {
        $this->sharedUsers->removeElement($sharedUser);
    }

    /**
     * Get sharedUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSharedUsers()
    {
        return $this->sharedUsers;
    }

    /**
     * Add like
     *
     * @param \Bundles\UserBundle\Entity\User $like
     *
     * @return Post
     */
    public function addLike(\Bundles\UserBundle\Entity\User $like)
    {
        $this->likes[] = $like;

        return $this;
    }

    /**
     * Remove like
     *
     * @param \Bundles\UserBundle\Entity\User $like
     */
    public function removeLike(\Bundles\UserBundle\Entity\User $like)
    {
        $this->likes->removeElement($like);
    }

    /**
     * Get likes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLikes()
    {
        return $this->likes;
    }
    /**
     * @var \Bundles\UserBundle\Entity\User
     */
    private $author;


    /**
     * Set author
     *
     * @param \Bundles\UserBundle\Entity\User $author
     *
     * @return Post
     */
    public function setAuthor(\Bundles\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Bundles\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }
    /**
     * @var integer
     */
    private $type;

    /**
     * @var \Bundles\StoreBundle\Entity\UpdatePost
     */
    private $updatePost;

    /**
     * @var \Bundles\StoreBundle\Entity\OpportunityPost
     */
    private $opportunityPost;


    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Post
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set updatePost
     *
     * @param \Bundles\StoreBundle\Entity\UpdatePost $updatePost
     *
     * @return Post
     */
    public function setUpdatePost(\Bundles\StoreBundle\Entity\UpdatePost $updatePost = null)
    {
        $this->updatePost = $updatePost;

        return $this;
    }

    /**
     * Get updatePost
     *
     * @return \Bundles\StoreBundle\Entity\UpdatePost
     */
    public function getUpdatePost()
    {
        return $this->updatePost;
    }

    /**
     * Set opportunityPost
     *
     * @param \Bundles\StoreBundle\Entity\OpportunityPost $opportunityPost
     *
     * @return Post
     */
    public function setOpportunityPost(\Bundles\StoreBundle\Entity\OpportunityPost $opportunityPost = null)
    {
        $this->opportunityPost = $opportunityPost;

        return $this;
    }

    /**
     * Get opportunityPost
     *
     * @return \Bundles\StoreBundle\Entity\OpportunityPost
     */
    public function getOpportunityPost()
    {
        return $this->opportunityPost;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $comment;


    /**
     * Add comment
     *
     * @param \Bundles\StoreBundle\Entity\Comment $comment
     *
     * @return Post
     */
    public function addComment(\Bundles\StoreBundle\Entity\Comment $comment)
    {
        $this->comment[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \Bundles\StoreBundle\Entity\Comment $comment
     */
    public function removeComment(\Bundles\StoreBundle\Entity\Comment $comment)
    {
        $this->comment->removeElement($comment);
    }

    /**
     * Get comment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComment()
    {
        return $this->comment;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $communities;


    /**
     * Add community
     *
     * @param \Bundles\StoreBundle\Entity\Community $community
     *
     * @return Post
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
     * @var \Bundles\StoreBundle\Entity\EventPost
     */
    private $eventPost;


    /**
     * Set eventPost
     *
     * @param \Bundles\StoreBundle\Entity\EventPost $eventPost
     *
     * @return Post
     */
    public function setEventPost(\Bundles\StoreBundle\Entity\EventPost $eventPost = null)
    {
        $this->eventPost = $eventPost;

        return $this;
    }

    /**
     * Get eventPost
     *
     * @return \Bundles\StoreBundle\Entity\EventPost
     */
    public function getEventPost()
    {
        return $this->eventPost;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $likedUsers;


    /**
     * Add likedUser
     *
     * @param \Bundles\StoreBundle\Entity\LikePost $likedUser
     *
     * @return Post
     */
    public function addLikedUser(\Bundles\StoreBundle\Entity\LikePost $likedUser)
    {
        $this->likedUsers[] = $likedUser;

        return $this;
    }

    /**
     * Remove likedUser
     *
     * @param \Bundles\StoreBundle\Entity\LikePost $likedUser
     */
    public function removeLikedUser(\Bundles\StoreBundle\Entity\LikePost $likedUser)
    {
        $this->likedUsers->removeElement($likedUser);
    }

    /**
     * Get likedUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLikedUsers()
    {
        return $this->likedUsers;
    }
}
