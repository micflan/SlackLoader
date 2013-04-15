<?php

require_once(DIR . '../system/config.php');
require_once(DIR . '../pagemaster.php');

/**
 * Wordrelease
 *
 * @version 0.1
 * @author Michael Flanagan (michael@flanagan.ie)
 **/
class Wordrelease
{
    private $tmpl;
    private $pages;
    private $config;
    private $post_data;
    private $banned_uris;

    public function __construct($config, $pages = array()) {
        $this->tmpl   = $config['tmpl'];
        $this->config = $config;
        $this->pages  = $pages;

        $this->banned_uris = array('_','_404', $this->config['pagination_prefix']);

        $uri  = $this->parseUrl();
        $tmpl = $this->tmpl;

        if (empty($uri) or strpos($uri, str_replace('/', '.', $this->config['posts_url_prefix']) . 'page.', 0) === 0) {
            // Home Page
            $this->tmpl = array_merge($this->tmpl, $this->pages['_']);
        } elseif (!in_array($uri, $this->banned_uris) and !empty($this->pages[$uri])) {
            // Page
            $this->tmpl = array_merge($this->tmpl, $this->pages[$uri]);
        } elseif ($post = $this->getArticle($uri, true)) {
            // Blog post
            $this->post_data = $post['data'];
        } else {
            // 404  – Page Not Found
            header('HTTP/1.0 404 Not Found');
            $this->tmpl = array_merge($this->tmpl, $this->pages['_404']);
        }
    }

    public function config($key)
    {
        return !empty($this->config[$key]) ? $this->config[$key] : false;
    }

    public function getTemplateHeader()
    {
        return !empty($this->tmpl['_page_header']) ? $this->tmpl['_page_header'] : false;
    }

    public function getTemplateBody()
    {
        return $this->tmpl['_page'];
    }

    public function getTemplateFooter()
    {
        return !empty($this->tmpl['_page_footer']) ? $this->tmpl['_page_footer'] : false;
    }

    public function getTemplateVars()
    {
        return $this->tmpl;
    }

    public function getPostData()
    {
        return $this->post_data ? $this->post_data : array();
    }

    /**
     * Get uri from url
     **/
    public function parseUrl ()
    {
        return trim(
            str_replace(
                array('/index.php', '/'),
                array('', '.'),
                $_SERVER['PHP_SELF']
            ),
        '.');
    }

    /**
     * getArticle
     * retrieves json post file matching $uid
     * and returns 'tmpl' and 'data' arrays ready for use in template
     *
     * @return array('data','tmpl'); or false
     **/
    public function getArticle ($uid, $tmpl = false)
    {
        if (file_exists($this->config['posts_dir'] . str_replace($this->config['posts_url_prefix'], '', $uid) . '.json')) {

            // Get data from JSON file
            $json = file_get_contents($this->config['posts_dir'] . $uid . '.json');
            $data = json_decode($json, true);
            $data['category_text'] = implode(', ', $data['categories']);

            if ($tmpl === true) {
                // Set template variables
                $this->tmpl['page_title']  = $data['title'] . ' – ' . $this->tmpl['page_title'];
                $this->tmpl['page_class']  = 'pagePost' . (!empty($data['page_class']) ? ' ' . $data['page_class'] : '');
                $this->tmpl['page_id']     = 'page-' . $data['uid'];
                $this->tmpl['nav_page']    = 'post';
                $this->tmpl['javascript'] .= !empty($data['javascript']) ? $data['javascript'] : '';
                $this->tmpl['css']        .= !empty($data['css']) ? $data['css'] : '';

                // Check for custom template files
                if (file_exists($this->config['posts_url_prefix'] . $data['uid'] . '.php')) {
                    $this->tmpl['_page'] = $this->config['posts_url_prefix'] . $data['uid'] . '.php';
                } else {
                    $this->tmpl['_page'] = $this->tmpl['_post_template'];
                }
                if (file_exists($this->config['posts_url_prefix'] . $data['uid'] . '_header.php')) {
                    $this->tmpl['_page_header'] = $this->config['posts_url_prefix'] . $data['uid'] . '_header.php';
                }
                if (file_exists($this->config['posts_url_prefix'] . $data['uid'] . '_footer.php')) {
                    $this->tmpl['_page_footer'] = $this->config['posts_url_prefix'] . $data['uid'] . '_footer.php';
                }
            }

            return array('data' => $data, 'tmpl' => $tmpl);
        }

        return false;
    }

} // END class Wordrelease