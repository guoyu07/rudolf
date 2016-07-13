<?php
namespace Rudolf\Framework\View;

use Rudolf\Component\Alerts\AlertsCollection;
use Rudolf\Component\Html\Navigation;
use Rudolf\Component\Modules\Module;

class AdminView extends BaseView
{
    /**
     * @var array $userInfo
     * @access private
     */
    private static $userInfo;

    /**
     * @var array $adminData
     * @access private
     */
    private static $adminData;

    /**
     * @var string $active
     * @access private
     */
    private static $active;

    public function __construct()
    {
        $module = new Module('dashboard');
        $this->config = $module->getConfig();

        parent::__construct();
    }

    /**
     * Create page nav
     *
     * @param string $type
     * @param int $nesting
     * @param array $classes
     * @param array $before
     * @param array $after
     *
     * @return string
     */
    public function pageNav($type, $nesting = 0, $classes, $before = false, $after = false)
    {
        $nav = new Navigation();
        $nav->setType($type);
        $nav->setItems(self::$adminData['menu_items']);
        $nav->setCurrent(self::$active);
        $nav->setClasses($classes);
        $nav->setNesting($nesting);
        $nav->setBefore($before);
        $nav->setAfter($after);

        return $nav->create();
    }

    protected function pageTitle()
    {
        return $this->pageTitle;
    }

    public function adminDir()
    {
        return DIR . '/' . $this->config['admin_path'];
    }

    public function setActive($active) {
        self::$active = $active;
    }

    /**
     *
     * @return void
     */
    public static function setAdminData($adminData)
    {
        self::$adminData = $adminData;
    }

    /**
     *
     * @return void
     */
    public static function setUserInfo($userInfo)
    {
        self::$userInfo = $userInfo;
    }

    /**
     *
     * @return string
     */
    protected function getUserName()
    {
        return self::$userInfo['first_name'];
    }

    /**
     *
     * @return string
     */
    protected function getUserFullName()
    {
        return self::$userInfo['first_name'] . ' ' . self::$userInfo['surname'];
    }

    /**
     *
     * @return string
     */
    protected function getUserEmail()
    {
        return self::$userInfo['email'];
    }

    /**
     *
     * @return string
     */
    protected function getUserNick()
    {
        return self::$userInfo['nick'];
    }

    /**
     *
     * @return string
     */
    protected function getUserRegisterDate()
    {
        return self::$userInfo['dt'];
    }

    /**
     * Get all alerts
     *
     * @param array
     */
    protected function alerts($classes = [])
    {
        if(!$this->isAlerts()) {
            return false;
        }

        $classes = array_merge([
            'danger' => 'danger',
            'error' => 'error',
            'warning' => 'warning',
            'success' => 'success',
            'info' => 'info'
        ], $classes);

        $a = AlertsCollection::getAll();

        foreach ($a as $key => $alert) {
            $html[] = $this->alert($alert->getType(), $alert->getMessage(), $classes);
        }

        return implode("\n", $html);
    }

    protected function isAlerts()
    {
        if (AlertsCollection::isAlerts()) {
            return true;
        }
        return false;
    }

    /**
     * Get code for one alert
     *
     * @param string $type
     * @param string $message
     * @param array $classes
     *
     * @return string
     */
    protected function alert($type, $message, $classes = '')
    {
        $html[] = sprintf('<div class="alert alert-%1$s %1$s">', $classes[$type]);
        $html[] = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        $html[] = sprintf('<strong>%1$s!</strong> %2$s', ucfirst($type), $message);
        $html[] = '</div>';

        return implode('', $html);
    }
}