<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Nette\Mail\Message;
use Nette\Mail\SmtpMailer;
use PHPMailer\PHPMailer\PHPMailer;

class EmailServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
    /**
     * 传入邮箱获取邮箱前缀
     * 成功返回邮箱，失败返回空
     * add by 毛毛
     * 2018年6月25日15:12:32
     */
    public static function get_prefix($email){
        $key = '@';
        $rt = '';
        for($i=0;$i<strlen($email);$i++){
            if($email[$i]==$key){
                break;
            }
            $rt = $rt.$email[$i];
        }
        return $rt;
    }

    /**
     * 传入邮箱获取邮箱后缀
     * 成功返回邮箱后缀，失败返回空
     * add by 毛毛
     * 2018年6月25日15:27:33
     */
    public static function get_suffix($email){
        $key = '@';
        $rt = '';
        $after = false;
        for($i=0;$i<strlen($email);$i++){
            if($email[$i]==$key){
                $after = true;
                $rt = "@";
                continue;
            }
            if ($after){
                $rt = $rt.$email[$i];
            }
        }
        return $rt;
    }

    /**
     * 传入邮箱获取邮箱后缀
     * 成功返回邮箱后缀，失败返回空
     * add by 毛毛
     * 2018年6月25日15:27:33
     */
    public static function send_email($user,$book){

        $mail = new Message();
        $mail->setFrom($user->send_email)
            ->addTo("962212011@qq.com")
            ->setSubject($book['name'])
//            ->addAttachment($book['file_path'])
            ->setBody("");
        $mailer = new SmtpMailer(array(
            'host' => 'smtp.163.com',
//            'port' => 25,
            'username' => $user->send_email,# 你的 163 用户名
            'password' => $user->auth_code  # 你的邮箱授权码
        ));
        try{
            $mailer->send($mail);
            return true;
        }catch (\Exception $e){
            var_dump($e);
            return false;
        }
    }

    public static function sendFile($user,$book){
        $mail = new PHPMailer(true);
//        var_dump($mail);exit;// Passing `true` enables exceptions
//        var_dump($book);
//        var_dump($user->receive_email);
//        var_dump($user->auth_code);
//        var_dump($user->send_email);exit;
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.163.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $user->send_email;                 // SMTP username
            $mail->Password = $user->auth_code;                           // SMTP password
            //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
//            $mail->Port = 25;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($user->send_email, 'kindle');
//            $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
            $mail->addAddress($user->receive_email);               // Name is optional
//            $mail->addReplyTo('info@example.com', 'Information');
//            $mail->addCC('cc@example.com');
//            $mail->addBCC('bcc@example.com');
            $mail->SMTPSecure = "ssl";
            $mail->Port=465;
            //Attachments
//            $mail->addAttachment('http://pbblrj82c.bkt.clouddn.com/2016%E4%BA%9A%E9%A9%AC%E9%80%8A%E7%95%85%E9%94%80%E4%B9%A6%E6%8E%92%E8%A1%8C%E6%A6%9C%E4%B9%A6%E7%B1%8D/%E4%B9%8C%E5%90%88%E4%B9%8B%E4%BC%97%EF%BC%9A%E5%A4%A7%E4%BC%97%E5%BF%83%E7%90%86%E7%A0%94%E7%A9%B6.mobi');         // Add attachments
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->addAttachment($book['file_path']);
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $book['name'];
            $mail->Body    = $book['name'];
//            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
//            echo 'Message has been sent';
            return true;
        } catch (\Exception $e) {
            return false;
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }




}
