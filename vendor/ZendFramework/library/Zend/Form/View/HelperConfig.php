<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Form
 */

namespace Zend\Form\View;

use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Service manager configuration for form view helpers
 *
 * @category   Zend
 * @package    Zend_Form
 * @subpackage View
 */
class HelperConfig implements ConfigInterface
{
    /**
     * @var array Pre-aliased view helpers
     */
    protected $invokables = array(
        'form'                   => 'Zend\Form\View\Helper\Form',
        'formbutton'             => 'Zend\Form\View\Helper\FormButton',
        'formcaptcha'            => 'Zend\Form\View\Helper\FormCaptcha',
        'captchadumb'            => 'Zend\Form\View\Helper\Captcha\Dumb',
        'formcaptchadumb'        => 'Zend\Form\View\Helper\Captcha\Dumb',
        'captchafiglet'          => 'Zend\Form\View\Helper\Captcha\Figlet',
        'formcaptchafiglet'      => 'Zend\Form\View\Helper\Captcha\Figlet',
        'captchaimage'           => 'Zend\Form\View\Helper\Captcha\Image',
        'formcaptchaimage'       => 'Zend\Form\View\Helper\Captcha\Image',
        'captcharecaptcha'       => 'Zend\Form\View\Helper\Captcha\ReCaptcha',
        'formcaptcharecaptcha'   => 'Zend\Form\View\Helper\Captcha\ReCaptcha',
        'formcheckbox'           => 'Zend\Form\View\Helper\FormCheckbox',
        'formcollection'         => 'Zend\Form\View\Helper\FormCollection',
        'formcolor'              => 'Zend\Form\View\Helper\FormColor',
        'formdate'               => 'Zend\Form\View\Helper\FormDate',
        'formdatetime'           => 'Zend\Form\View\Helper\FormDateTime',
        'formdatetimelocal'      => 'Zend\Form\View\Helper\FormDateTimeLocal',
        'formelement'            => 'Zend\Form\View\Helper\FormElement',
        'formelementerrors'      => 'Zend\Form\View\Helper\FormElementErrors',
        'formemail'              => 'Zend\Form\View\Helper\FormEmail',
        'formfile'               => 'Zend\Form\View\Helper\FormFile',
        'formhidden'             => 'Zend\Form\View\Helper\FormHidden',
        'formimage'              => 'Zend\Form\View\Helper\FormImage',
        'forminput'              => 'Zend\Form\View\Helper\FormInput',
        'formlabel'              => 'Zend\Form\View\Helper\FormLabel',
        'formmonth'              => 'Zend\Form\View\Helper\FormMonth',
        'formmulticheckbox'      => 'Zend\Form\View\Helper\FormMultiCheckbox',
        'formnumber'             => 'Zend\Form\View\Helper\FormNumber',
        'formpassword'           => 'Zend\Form\View\Helper\FormPassword',
        'formradio'              => 'Zend\Form\View\Helper\FormRadio',
        'formrange'              => 'Zend\Form\View\Helper\FormRange',
        'formreset'              => 'Zend\Form\View\Helper\FormReset',
        'form_reset'             => 'Zend\Form\View\Helper\FormReset',
        'formrow'                => 'Zend\Form\View\Helper\FormRow',
        'form_row'               => 'Zend\Form\View\Helper\FormRow',
        'formsearch'             => 'Zend\Form\View\Helper\FormSearch',
        'formselect'             => 'Zend\Form\View\Helper\FormSelect',
        'formsubmit'             => 'Zend\Form\View\Helper\FormSubmit',
        'formtel'                => 'Zend\Form\View\Helper\FormTel',
        'formtext'               => 'Zend\Form\View\Helper\FormText',
        'formtextarea'           => 'Zend\Form\View\Helper\FormTextarea',
        'formtime'               => 'Zend\Form\View\Helper\FormTime',
        'formurl'                => 'Zend\Form\View\Helper\FormUrl',
        'formweek'               => 'Zend\Form\View\Helper\FormWeek',
    );

    /**
     * Configure the provided service manager instance with the configuration
     * in this class.
     *
     * In addition to using each of the internal properties to configure the
     * service manager, also adds an initializer to inject ServiceManagerAware
     * classes with the service manager.
     *
     * @param  ServiceManager $serviceManager
     * @return void
     */
    public function configureServiceManager(ServiceManager $serviceManager)
    {
        foreach ($this->invokables as $name => $service) {
            $serviceManager->setInvokableClass($name, $service);
        }
    }
}