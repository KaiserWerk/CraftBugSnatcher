<?php
/**
 * BugSnatcher plugin for Craft CMS 3.x
 *
 * A handy plugin for catching and recording errors and exceptions. Also sends out notifications via Mail, Slack, Stride and SMS.
 *
 * @link      https://kaiserrobin.eu
 * @copyright Copyright (c) 2018 Robin Kaiser
 */

namespace kaiserwerk\bugsnatcher\models;

use kaiserwerk\bugsnatcher\BugSnatcher;

use Craft;
use craft\base\Model;

/**
 * BugSnatcher Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Robin Kaiser
 * @package   BugSnatcher
 * @since     1.0.0
 */
class Settings extends Model
{
    public $emailActive;
    public $email;
    
    public $slackActive;
    public $slackApiKey;
    public $slackChannel;
    
    public $strideActive;
    public $strideBearerToken;
    public $strideCloudID;
    public $strideConversationID;
    
    public $smsActive;
    public $smsApiKey;
    public $smsNumber;
    
    public function rules()
    {
        return [
            //[['foo', 'bar'], 'required'],
        ];
    }
    
    protected function createSettingsModel()
    {
        return new \kaiserwerk\bugsnatcher\models\Settings();
    }
}
