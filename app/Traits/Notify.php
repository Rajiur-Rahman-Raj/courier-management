<?php

namespace App\Traits;

use App\Events\AdminNotification;
use App\Events\UserNotification;
use App\Mail\SendMail;
use App\Models\Admin;
use App\Models\EmailTemplate;
use App\Models\NotifyTemplate;
use App\Models\SiteNotification;
use App\Models\SmsControl;
use Illuminate\Support\Facades\Mail;
use Facades\App\Services\BasicCurl;

trait Notify
{
    public function sendMailSms($user, $templateKey, $params = [], $subject = null, $requestMessage = null)
    {
        $this->mail($user, $templateKey, $params, $subject, $requestMessage);
        $this->sms($user, $templateKey, $params, $requestMessage = null);
    }

	public function mail($user, $templateKey = null, $params = [], $subject = null, $requestMessage = null)
	{
		$basic = basicControl();

		if ($basic->email_notification != 1) {
			return false;
		}

		$email_body = $basic->email_description;
		$templateObj = EmailTemplate::where('template_key', $templateKey)->where('language_id', $user->language_id)->where('mail_status', 1)->first();
		if (!$templateObj) {
			$templateObj = EmailTemplate::where('template_key', $templateKey)->where('mail_status', 1)->first();
		}
		$message = str_replace("[[name]]", $user->username, $email_body);

		if (!$templateObj && $subject == null) {
			return false;
		} else {
			if ($templateObj) {
				$message = str_replace("[[message]]", $templateObj->template, $message);
				if (empty($message)) {
					$message = $email_body;
				}
				foreach ($params as $code => $value) {
					$message = str_replace('[[' . $code . ']]', $value, $message);
				}
			} else {
				$message = str_replace("[[message]]", $requestMessage, $message);
			}
		}

		$subject = ($subject == null) ? $templateObj->subject : $subject;
		$email_from = ($templateObj) ? $templateObj->email_from : $basic->sender_email;

		Mail::to($user)->queue(new SendMail($email_from, $subject, $message));
	}

	public function sms($user, $templateKey, $params = [], $requestMessage = null)
	{
		$basic = basicControl();
		if ($basic->sms_notification != 1 || !$user->profile) {
			return false;
		}

		$smsControl = SmsControl::firstOrCreate(['id' => 1]);

		$templateObj = EmailTemplate::where('template_key', $templateKey)->where('language_id', $user->language_id)->where('sms_status', 1)->first();
		if (!$templateObj) {
			$templateObj = EmailTemplate::where('template_key', $templateKey)->where('sms_status', 1)->first();
		}

		if (!$templateObj && $requestMessage == null) {
			return false;
		} else {
			if ($templateObj) {
				$template = $templateObj->sms_body;
				foreach ($params as $code => $value) {
					$template = str_replace('[[' . $code . ']]', $value, $template);
				}
			} else {
				$template = $requestMessage;
			}
		}


		$headerData = is_null($smsControl->headerData) ? [] : json_decode($smsControl->headerData, true);
		$paramData = is_null($smsControl->paramData) ? [] : json_decode($smsControl->paramData, true);
		$paramData = http_build_query($paramData);
		$actionUrl = $smsControl->actionUrl;
		$actionMethod = $smsControl->actionMethod;
		$formData = is_null($smsControl->formData) ? [] : json_decode($smsControl->formData, true);
		$formData = isset($headerData['Content-Type']) && $headerData['Content-Type'] == "application/x-www-form-urlencoded" ? http_build_query($formData) : (isset($headerData['Content-Type']) && $headerData['Content-Type'] == "application/json" ? json_encode($formData) : $formData);

		foreach ($headerData as $key => $data) {
			$headerData[] = "{$key}:$data";
		}

		if ($actionMethod == 'GET') {
			$actionUrl = $actionUrl . '?' . $paramData;
		}

		$formData = recursive_array_replace("[[receiver]]", $user->phone, recursive_array_replace("[[message]]", $template, $formData));
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $actionUrl,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $actionMethod,
			CURLOPT_POSTFIELDS => $formData,
			CURLOPT_HTTPHEADER => $headerData
		));

		$response = curl_exec($curl);
		curl_close($curl);
		return $response;


	}


	public function verifyToMail($user, $templateKey = null, $params = [], $subject = null, $requestMessage = null)
    {
        $basic = basicControl();

        if ($basic->email_verification != 1) {
            return false;
        }

        $email_body = $basic->email_description;
        $templateObj = EmailTemplate::where('template_key', $templateKey)->where('language_id', $user->language_id)->where('mail_status', 1)->first();
        if (!$templateObj) {
            $templateObj = EmailTemplate::where('template_key', $templateKey)->where('mail_status', 1)->first();
        }
        $message = str_replace("[[name]]", $user->username, $email_body);

        if (!$templateObj && $subject == null) {
            return false;
        } else {
            if ($templateObj) {
                $message = str_replace("[[message]]", $templateObj->template, $message);
                if (empty($message)) {
                    $message = $email_body;
                }
                foreach ($params as $code => $value) {
                    $message = str_replace('[[' . $code . ']]', $value, $message);
                }
            } else {
                $message = str_replace("[[message]]", $requestMessage, $message);
            }
        }

        $subject = ($subject == null) ? $templateObj->subject : $subject;
        $email_from = ($templateObj) ? $templateObj->email_from : $basic->sender_email;

        Mail::to($user)->send(new SendMail($email_from, $subject, $message));
    }

    public function verifyToSms($user, $templateKey, $params = [], $requestMessage = null)
    {
        $basic = basicControl();
        if ($basic->sms_verification != 1 || !$user->profile) {
            return false;
        }

		$smsControl = SmsControl::firstOrCreate(['id' => 1]);

		$templateObj = EmailTemplate::where('template_key', $templateKey)->where('language_id', $user->language_id)->where('sms_status', 1)->first();
		if (!$templateObj) {
			$templateObj = EmailTemplate::where('template_key', $templateKey)->where('sms_status', 1)->first();
		}

		if (!$templateObj && $requestMessage == null) {
			return false;
		} else {
			if ($templateObj) {
				$template = $templateObj->sms_body;
				foreach ($params as $code => $value) {
					$template = str_replace('[[' . $code . ']]', $value, $template);
				}
			} else {
				$template = $requestMessage;
			}
		}


		$headerData = is_null($smsControl->headerData) ? [] : json_decode($smsControl->headerData, true);
		$paramData = is_null($smsControl->paramData) ? [] : json_decode($smsControl->paramData, true);
		$paramData = http_build_query($paramData);
		$actionUrl = $smsControl->actionUrl;
		$actionMethod = $smsControl->actionMethod;
		$formData = is_null($smsControl->formData) ? [] : json_decode($smsControl->formData, true);
		$formData = isset($headerData['Content-Type']) && $headerData['Content-Type'] == "application/x-www-form-urlencoded" ? http_build_query($formData) : (isset($headerData['Content-Type']) && $headerData['Content-Type'] == "application/json" ? json_encode($formData) : $formData);

		foreach ($headerData as $key => $data) {
			$headerData[] = "{$key}:$data";
		}

		if ($actionMethod == 'GET') {
			$actionUrl = $actionUrl . '?' . $paramData;
		}

		$formData = recursive_array_replace("[[receiver]]", $user->phone, recursive_array_replace("[[message]]", $template, $formData));
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $actionUrl,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $actionMethod,
			CURLOPT_POSTFIELDS => $formData,
			CURLOPT_HTTPHEADER => $headerData
		));

		$response = curl_exec($curl);
		curl_close($curl);
		return $response;


	}

    public function userPushNotification($user, $templateKey, $params = [], $action = [])
    {
        $basic = basicControl();
        if ($basic->push_notification != 1) {
            return false;
        }

        $templateObj = NotifyTemplate::where('template_key', $templateKey)->where('language_id', $user->language_id)->where('status', 1)->first();
        if (!$templateObj) {
            $templateObj = NotifyTemplate::where('template_key', $templateKey)->where('status', 1)->first();
        }

        if ($templateObj) {
            $template = $templateObj->body;
            foreach ($params as $code => $value) {
                $template = str_replace('[[' . $code . ']]', $value, $template);
            }
            $action['text'] = $template;
        }

        $siteNotification = new SiteNotification();
        $siteNotification->description = $action;
        $user->siteNotificational()->save($siteNotification);

        event(new UserNotification($siteNotification, $user->id));

    }

    public function adminPushNotification($admin, $templateKey, $params = [], $action = [], $superAdmin = null)
    {
        $basic = basicControl();
        if ($basic->push_notification != 1) {
            return false;
        }

        $templateObj = NotifyTemplate::where('template_key', $templateKey)->where('status', 1)->first();
        if (!$templateObj) {
            return false;
        }

        if ($templateObj) {
            $template = $templateObj->body;
            foreach ($params as $code => $value) {
                $template = str_replace('[[' . $code . ']]', $value, $template);
            }
            $action['text'] = $template;
        }

		if ($superAdmin){
			$superAdmin = Admin::where('is_owner', 1)->whereNull('role_id')->first();
			$siteNotification = new SiteNotification();
			$siteNotification->description = $action;
			$superAdmin->siteNotificational()->save($siteNotification);
			event(new AdminNotification($siteNotification, $superAdmin->id));
		}

		$siteNotification = new SiteNotification();
		$siteNotification->description = $action;
		$admin->siteNotificational()->save($siteNotification);
		event(new AdminNotification($siteNotification, $admin->id));

//        $admins = Admin::all();
//        foreach ($admins as $admin) {
//
//        }
    }


    public function adminMail($admin, $templateKey = null, $params = [], $subject = null, $requestMessage = null, $superAdmin = null)
    {

        $basic = basicControl();

        if ($basic->email_notification != 1) {
            return false;
        }

        $email_body = $basic->email_description;
        $templateObj = EmailTemplate::where('template_key', $templateKey)->where('mail_status', 1)->first();
        if (!$templateObj) {
            $templateObj = EmailTemplate::where('template_key', $templateKey)->where('mail_status', 1)->first();
        }

        $message = $email_body;
        if ($templateObj) {
            $message = str_replace("[[message]]", $templateObj->template, $message);
            if (empty($message)) {
                $message = $email_body;
            }
            foreach ($params as $code => $value) {
                $message = str_replace('[[' . $code . ']]', $value, $message);
            }
        } else {
            $message = str_replace("[[message]]", $requestMessage, $message);
        }

        $subject = ($subject == null && $templateObj != null) ? $templateObj->subject : $subject;
        $email_from = ($templateObj) ? $templateObj->email_from : $basic->sender_email;

		if ($superAdmin){
			$superAdmin = Admin::where('is_owner', 1)->whereNull('role_id')->first();
			$message = str_replace("[[name]]", $superAdmin->username, $message);
			Mail::to($superAdmin)->queue(new SendMail($email_from, $subject, $message));
		}

//		$message = str_replace("[[name]]", $admin->username, $message);
//		Mail::to($admin)->queue(new SendMail($email_from, $subject, $message));

//		$admins = Admin::all();
//        foreach ($admins as $admin) {
//            $message = str_replace("[[name]]", $admin->username, $message);
//            Mail::to($admin)->queue(new SendMail($email_from, $subject, $message));
//        }
    }
}
