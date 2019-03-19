<?php

/**
 * This file contains PCSG\Makerlog\Api\Products\Product
 */

namespace PCSG\Makerlog\Api\Products;

use GuzzleHttp\RequestOptions;
use PCSG\Makerlog\Api\Projects\Project;
use PCSG\Makerlog\Api\Users\User;
use PCSG\Makerlog\Exception;
use PCSG\Makerlog\Makerlog;

/**
 * Class Product
 *
 * @package PCSG\Makerlog\Api\Products
 */
class Product
{
    /**
     * @var Makerlog
     */
    protected $Makerlog;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var array
     */
    protected $data = null;

    /**
     * Project owner
     *
     * @var User
     */
    protected $User;

    /**
     * Product constructor
     *
     * @param integer $slug - product name / identifier
     * @param Makerlog $Makerlog - main makerlog instance
     */
    public function __construct($slug, Makerlog $Makerlog)
    {
        $this->Makerlog = $Makerlog;
        $this->slug     = $slug;
    }

    //region data

    /**
     * helper method to get the product data
     * this method fetches the data only once, because of performance and spamming action
     *
     * if you want to fetch new data, use refresh()
     * but please, use this wisely
     *
     * @return object
     * @throws Exception
     */
    protected function getProductData()
    {
        if ($this->data === null) {
            $this->data = $this->Makerlog->getProducts()->get($this->slug);
        }

        return $this->data;
    }

    /**
     * resets the internal data of the product
     * so the data will be fetched again.
     *
     * look at getProductData();
     */
    public function refresh()
    {
        $this->data = null;

        try {
            $this->getProductData();
        } catch (Exception $Exception) {
        }
    }

    //endregion

    //region getter

    /**
     * Return all users which are related to the product
     *
     * @return User[]
     */
    public function getPeople()
    {
        try {
            $Response = $this->Makerlog->getRequest()->get('/products/' . $this->slug . '/people/');
            $result   = json_decode($Response->getBody());

            $users = [];

            foreach ($result as $entry) {
                $users[] = new User($entry->id, $this->Makerlog, $entry);
            }

            return $users;
        } catch (Exception $Exception) {
            return [];
        }
    }

    /**
     * Alias for getPeople
     *
     * @return User[]
     */
    public function getUsers()
    {
        return $this->getPeople();
    }

    /**
     * Return the project list which is related to the product
     *
     * @return Project[]
     */
    public function getProjects()
    {
        try {
            $Response = $this->Makerlog->getRequest()->get('/products/' . $this->slug . '/projects/');
            $result   = json_decode($Response->getBody());

            $products = [];

            foreach ($result as $entry) {
                $products[] = new Project($entry->id, $this->Makerlog, $entry);
            }

            return $products;
        } catch (Exception $Exception) {
            return [];
        }
    }

    /**
     * Return the product stats
     *
     * stats->week_tda
     * stats->done_today
     *
     * @return array
     */
    public function getStats()
    {
        try {
            $Response = $this->Makerlog->getRequest()->get('/products/' . $this->slug . '/stats');
            $result   = json_decode($Response->getBody());

            return $result;
        } catch (Exception $Exception) {
            return [];
        }
    }

    /**
     * Return the complete project data
     *
     * @return object
     */
    public function getData()
    {
        try {
            return $this->getProductData();
        } catch (Exception $Exception) {
            return (object)[];
        }
    }

    // normal getter

    /**
     * Return the product slug
     * - its like an identifier
     *
     * @return integer
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Return the product name
     *
     * @return string
     * @throws Exception
     */
    public function getName()
    {
        return $this->getProductData()->name;
    }

    /**
     * Return the product description
     *
     * @return string
     * @throws Exception
     */
    public function getDescription()
    {
        return $this->getProductData()->description;
    }

    /**
     * Return the ProductHunt handle
     *
     * @return string
     * @throws Exception
     */
    public function getProductHunt()
    {
        return $this->getProductData()->product_hunt;
    }

    /**
     * Return the twitter handle
     *
     * @return string
     * @throws Exception
     */
    public function getTwitter()
    {
        return $this->getProductData()->twitter;
    }

    /**
     * Return the website
     *
     * @return string
     * @throws Exception
     */
    public function getWebsite()
    {
        return $this->getProductData()->website;
    }

    /**
     * Return the product description
     *
     * @return string
     * @throws Exception
     */
    public function getIcon()
    {
        return $this->getProductData()->icon;
    }

    /**
     * Return the created date
     *
     * @return string
     * @throws Exception
     */
    public function getCreateDate()
    {
        return $this->getProductData()->created_at;
    }

    /**
     * Return the project owner
     *
     * @return User
     * @throws Exception
     */
    public function getUser()
    {
        if ($this->User) {
            return $this->User;
        }

        $user = $this->getProductData()->user;
        $User = $this->Makerlog->getUsers()->getUserObject($user);

        $this->User = $User;

        return $User;
    }

    /**
     * Return the launch date
     *
     * @return string
     * @throws Exception
     */
    public function getLaunchDate()
    {
        return $this->getProductData()->launched_at;
    }

    /**
     * Is the product launched?
     *
     * @return bool
     */
    public function isLaunched()
    {
        try {
            return (bool)$this->getProductData()->launched;
        } catch (Exception $Exception) {
            return false;
        }
    }

    //endregion

    //region change

    /**
     * Update / change a product
     *
     * @param array $options - optional, default = [
     *      "name"  => '',
     *      "slug"  => '',
     *      "user"  => 1222
     * ]
     *
     * @throws Exception
     */
    public function update($options = [])
    {
        if (empty($options)) {
            throw new Exception("Options can't be empty", 400);
        }

        $params = [];

        $allowed = [
            'name',
            'slug',
            'icon',
            'description',
            'user',
            'product_hunt',
            'twitter',
            'website',
            'launched',
            'created_at',
            'launched_at'
        ];

        foreach ($allowed as $key) {
            if (isset($options[$key])) {
                $params[$key] = $options[$key];
            }
        }

        if (empty($params)) {
            throw new Exception(
                "Can't send the update request. Data are empty. Options has forbidden entries",
                406
            );
        }

        $this->Makerlog->getRequest()->patch('/products/' . $this->slug . '/', [
            'form_params' => $params
        ]);

        $this->refresh();
    }

    /**
     * Delete this product
     *
     * @throws Exception
     */
    public function delete()
    {
        $this->Makerlog->getRequest()->delete('/products/' . $this->slug . '/');
    }

    /**
     * Launch the product
     * - Set the launch date to today
     *
     * @throws Exception
     */
    public function launch()
    {
        $this->update(['launched' => true]);
    }

    //endregion

    //region team

    /**
     * Add a user to the team
     *
     * @param User $User
     * @throws Exception
     */
    public function removeUserFromTeam(User $User)
    {
        $data = $this->getProductData();
        $team = $data->team;

        if (!is_array($team) || empty($team)) {
            return;
        }

        if (($key = array_search($User->getId(), $team)) !== false) {
            unset($team[$key]);
        }

        $team = array_unique($team);

        $Request = $this->Makerlog->getRequest();
        $Request = $Request->patch('/products/' . $this->slug . '/', [
            RequestOptions::JSON => [
                'team' => $team
            ]
        ]);

        $this->data = json_decode($Request->getBody());
    }

    /**
     * Add a user to the team
     *
     * @param User $User
     * @throws Exception
     */
    public function addUserToTheTeam(User $User)
    {
        $data = $this->getProductData();
        $team = $data->team;

        if (!is_array($team)) {
            $team = [];
        }

        $team[] = $User->getId();
        $team   = array_unique($team);

        $Request = $this->Makerlog->getRequest();
        $Request = $Request->patch('/products/' . $this->slug . '/', [
            RequestOptions::JSON => [
                'team' => $team
            ]
        ]);

        $this->data = json_decode($Request->getBody());
    }

    //endregion
}
