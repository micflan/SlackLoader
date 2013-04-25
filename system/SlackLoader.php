<?php

/**
 * SlackLoader
 *
 * @version 0.1b
 * @author Michael Flanagan (michael@flanagan.ie)
 **/
class SlackLoader
{
    public $uri;
    private $tmpl;
    private $pages;
    private $config;
    private $page_data;
    private $banned_uris;

    public function __construct($config) {

        // Can't access these urls directly.
        $this->banned_uris = array('_');

        $this->parseUrl();
        $this->config = $config;
        $this->tmpl   = $config['tmpl'];

    }

    public function config($key) {
        return !empty($this->config[$key]) ? $this->config[$key] : false;
    }

    public function getTemplateHeader() {
        return !empty($this->tmpl['_page_header']) ? $this->tmpl['_page_header'] : false;
    }

    public function getTemplateBody() {
        return $this->tmpl['_page'];
    }

    public function getTemplateFooter() {
        return !empty($this->tmpl['_page_footer']) ? $this->tmpl['_page_footer'] : false;
    }

    public function getTemplateVars() {
        return $this->tmpl;
    }

    public function getPageData() {
        return $this->page_data ? $this->page_data : array();
    }

    /**
     * Get uri from url
     **/
    private function parseUrl () {
        $uri = trim(
            str_replace(
                array('/index.php', '/'),
                array('', '.'),
                $_SERVER['PHP_SELF']
            ),
        '.');

        if(!empty($uri) and in_array($uri, $this->banned_uris)) {
            $uri = 'mightbeabetterwaytodothis' . rand(10000,50000);
        }

        $this->uri = $uri;
        return $uri;
    }

    public function isArticle($uid, $tmpl = false) {
        $prefix = str_replace('/', '.', $this->config['posts_url_prefix']);

        if (!empty($prefix)
            and substr( $uid, 0, strlen($prefix)) !== $prefix
            and $tmpl === true) {
            return false;
        }

        $uid = str_replace($prefix, '', $uid);

        if (file_exists(DIR . $this->config['posts_dir'] . $uid . '.json')) {
            return true;
        }

        return false;
    }

    public function isOldArticle($uid) {
        return (!empty($this->config['posts_url_prefix'])
            and file_exists(DIR . $this->config['posts_dir'] . $uid . '.json'));
    }

    /**
     * getArticle
     * retrieves json post file matching $uid
     * and returns 'tmpl' and 'data' arrays ready for use in template
     *
     * @return array('data','tmpl'); or false
     **/
    public function getArticle ($uid, $tmpl = false) {


        if ($this->isArticle($uid, $tmpl)) {
            $prefix = str_replace('/', '.', $this->config['posts_url_prefix']);
            $uid = str_replace($prefix, '', $uid);

            // Get data from JSON file
            $json = file_get_contents(DIR . $this->config['posts_dir'] . $uid . '.json');
            $cleanPage = $this->cleanPage(null, $uid);
            $data = array_merge($this->pages['_post'], $cleanPage, json_decode($json, true));

            $data['category_text'] = implode(', ', $data['categories']);
            $data['post_link'] = '/'.$this->config['posts_url_prefix'] . $uid;

            if ($tmpl === true) {
                // Set template variables
                $this->tmpl['page_title']  = $data['title'] . ' – ' . $this->tmpl['page_title'];
                $this->tmpl['page_class']  = 'pagePost' . (!empty($data['page_class']) ? ' ' . $data['page_class'] : '');
                $this->tmpl['page_id']     = 'page-' . $data['uid'];
                $this->tmpl['nav_page']    = 'post';
                $this->tmpl['jquery']      = !empty($data['jquery']) ? $data['jquery'] : $this->tmpl['jquery'];
                $this->tmpl['javascript'] .= !empty($data['javascript']) ? $data['javascript'] : '';
                $this->tmpl['css']        .= !empty($data['css']) ? $data['css'] : '';

                // Check for custom template files
                if (file_exists(DIR . $this->config['posts_dir'] . $data['uid'] . '.php')) {
                    $this->tmpl['_page'] = $this->config['posts_dir'] . $data['uid'] . '.php';
                } else {
                    $this->tmpl['_page'] = $this->tmpl['_post_template'];
                }
                if (file_exists(DIR . $this->config['posts_dir'] . $data['uid'] . '_header.php')) {
                    $this->tmpl['_page_header'] = $this->config['posts_dir'] . $data['uid'] . '_header.php';
                }
                if (file_exists(DIR . $this->config['posts_dir'] . $data['uid'] . '_footer.php')) {
                    $this->tmpl['_page_footer'] = $this->config['posts_dir'] . $data['uid'] . '_footer.php';
                }
            }

            return array('data' => $data, 'tmpl' => $tmpl);
        }

        return false;
    }

    /**
     * Load Page.
     * Match the current uri with a $pages entry and load $tmpl data.
     *
     **/
    public function loadPage($pages) {

        $uri = empty($this->uri) ? '_' : $this->uri;

        $pages = $this->cleanPages($pages);
        $this->pages = $pages;

        if ($this->isOldArticle($uri)) {
            header ('HTTP/1.1 301 Moved Permanently');
            header ('Location: '.$this->config['posts_url_prefix'].$uri);
            exit;

        } elseif ($this->isArticle($uri)) {

            // Blog post
            $this->tmpl = array_merge($this->tmpl, $pages['_post']);
            $post = $this->getArticle($uri, true);
            $this->page_data = $post['data'];

        } elseif (!empty($pages[array_shift(explode('.',$uri))])
            and $pages[array_shift(explode('.',$uri))]['pagination'] === true
            and is_numeric(array_pop(explode('.',$uri)))) {

            // Root level page
            $this->tmpl = array_merge($this->tmpl, $pages[array_shift(explode('.',$uri))]);
            $this->tmpl['root_level'] = array_shift(explode('.',$uri));
            $this->page_data = $pages[array_shift(explode('.',$uri))];

        } elseif (!empty($pages[$uri])
            and $pages[$uri]['top_level'] !== false) {

            // Page
            $this->tmpl = array_merge($this->tmpl, $pages[$uri]);
            $this->page_data = $pages[$uri];

        } else {

            // 404  – Page Not Found
            header('HTTP/1.0 404 Not Found');
            $this->tmpl = array_merge($this->tmpl, $pages['404']);
            $this->page_data = $pages['404'];
        }

        return $this;
    }

    /**
     * Clean pages.
     * Loops through an array of $pages and filling any missing requirements
     *
     **/
    private function cleanPages($pages) {
        $array = array();
        foreach ($pages as $uid => $page) {
            $array[$uid] = $this->cleanPage($page, $uid);
        }
        return $array;
    }
    /**
     * Clean page.
     * Fills any missing requirements
     *
     **/
    private function cleanPage($page = array(), $uid) {
        $complete = array (
            'site_title'       => $this->tmpl['site_title'],
            'site_address'     => $this->tmpl['site_address'],
            'site_description' => $this->tmpl['site_description'],
            'site_author'      => $this->tmpl['site_author'],
            'page_class'       => $this->tmpl['page_class'],
            'css'              => $this->tmpl['css'],
            'jquery'           => $this->tmpl['jquery'],
            'javascript'       => $this->tmpl['javascript'],
            'top_level'        => true,
            'pagination'       => false,
            'include_js'       => $this->tmpl['include_js'],
            'include_css'      => $this->tmpl['include_css'],
            'enable_disqus'    => $this->tmpl['enable_disqus'],
            'disqus_shortname' => $this->tmpl['disqus_shortname'],
        );

        if (is_array($page))
            $row = array_merge($complete, $page);

        if (empty($row['_page']))       $row['_page']      = 'pages/' . $uid . '.php';
        if (!isset($row['page_title'])) $row['page_title'] = ucfirst(str_replace('.', ' ', $uid));
        if (empty($row['nav_page']))    $row['nav_page']   = strtolower(str_replace('.', '_', $uid));
        if (empty($row['page_id']))     $row['page_id']    = 'page' . str_replace(' ', '', ucwords(str_replace('.',' ',$uid)));

        $row['uid'] = $uid === '_' ? '' : $uid;
        return $row;
    }

    /**
     * Show 404.
     * Send a 404 header and inculde 404 pages.
     *
     * (this could probably be handled better)
     *
     **/
    public function show404() {
        // 404  – Page Not Found
        header('HTTP/1.0 404 Not Found');
        $this->tmpl = array_merge($this->tmpl, $this->pages['404']);
        $tmpl = $this->tmpl;

        if ($this->getTemplateHeader()) include(DIR . $this->getTemplateHeader());
        include(DIR . $this->getTemplateBody());
        if ($this->getTemplateFooter()) include(DIR . $this->getTemplateFooter());
    }

} // END class Wordrelease