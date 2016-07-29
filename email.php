<?php

if(isset($_POST['signupformdata']) && isset($_POST['signupFormData'])) {
    require_once('config.php');
    require_once('packages/PHPMailer-master/PHPMailerAutoload.php');

    $signupformdata = $_POST['signupformdata'];
    $signupFormData = $_POST['signupFormData'];
    $date = date("Y-m-d H:i:s");

    $mail = new PHPMailer;
    $mail->isSMTP();

    $mail->Host = $Host;
    $mail->SMTPAuth = true;
    $mail->Username = $Username;
    $mail->Password = $Password;
    $mail->SMTPSecure = $SMTPSecure;
    $mail->Port = $Port;

    $mail->setFrom($FromEmail, $FromName);
    $mail->isHTML(true);

    $mail->addAddress('retailx@startups.co');

    $mail->Subject = 'Here is the subject';
    $mail->CharSet = 'UTF-8';

    $mail->Body = ' <h2>General Information</h2><hr>';
    $mail->Body .= '<table style="width:100%">
                        <tr>
                            <td>Date Submitted</td>
                            <td>'. (isset($date)?$date:'') .'</td>
                        </tr>
                        <tr>
                            <td>Full Name</td>
                            <td>'. (isset($signupformdata[0]['value'])?$signupformdata[0]['value']:'') .'</td>
                        </tr>
                        <tr>
                            <td>Email Address</td>
                            <td>'. (isset($signupformdata[1]['value'])?$signupformdata[1]['value']:'') .'</td>
                        </tr>
                        <tr>
                            <td>Company</td>
                            <td>'. (isset($signupformdata[2]['value'])?$signupformdata[2]['value']:'') .'</td>
                        </tr>
                        <tr>
                            <td>Industry / Sector</td>
                            <td>'. (isset($signupformdata[3]['value'])?$signupformdata[3]['value']:'') .'</td>
                        </tr>
                        <tr>
                            <td>Projected 2016 Revenue</td>
                            <td>'. (isset($signupformdata[4]['value'])?$signupformdata[4]['value']:'') .'</td>
                        </tr>';

        foreach($signupFormData as $i) {

            if($i['name'] == 'snp-benefits[]' ){
                if(!isset($first)){
                    $mail->Body .= '<tr><td>Accelerator Benefits</td><td>'.$i['value'].'</td></tr>';
                    $first = '111';
                }else{
                    $mail->Body .= '<tr><td> </td><td>'.$i['value'].'</td></tr>';
                }
            }

        }

        if(!isset($first)){
            $mail->Body .= '<tr><td>Accelerator Benefits</td><td> </td></tr>';
        }

        $mail->Body .= '</table>';
        $mail->Body .= '<h2>Team and Company</h2><hr><table style="width:100%">';
        foreach($signupFormData as $i) {

            if($i['name'] == 'snp-team-q1') {
                $mail->Body .= '<tr><td>Experience bringing a new product to market</td><td>'.(isset($i['value'])?(($i['value'] == 'true')?'YES':'NO') : ''). '</td></tr>';
            }

            if($i['name'] == 'snp-team-q2') {
                $mail->Body .= '<tr><td>Sales or distribution partner conversations</td><td>'.(isset($i['value'])?(($i['value'] == 'true')?'YES':'NO') : '').'</td></tr>';
            }

            if($i['name'] == 'snp-team-q3') {
                $mail->Body .= '<tr><td>Started selling products</td><td>'.(isset($i['value'])?(($i['value'] == 'true')?'YES':'NO') : '').'</td></tr>';
                if($i['value'] == 'true'){
                    foreach ($signupFormData as $data) {
                        if($data['name'] == 'snp-team-q3-yes[]'){
                            $mail->Body .= '<tr><td> </td><td>'.$data['value'].'</td></tr>';
                        }
                    }
                } else if($i['value'] == 'false') {
                    foreach ($signupFormData as $data) {
                        if($data['name'] == 'snp-q3-option-no' && $data['value'] == 'true'){

                            $mail->Body .= '<tr><td>Do you intend to sell through retail or distributors? </td><td>'.(isset($data['value'])?(($data['value'] == 'true')?'YES':'NO') : '').'</td></tr>';

                        }elseif($data['name'] == 'snp-q3-option-no' && $data['value'] == 'false'){

                            $mail->Body .= '<tr><td>Do you intend to sell through retail or distributors? </td><td>'.(isset($data['value'])?(($data['value'] == 'true')?'YES':'NO') : '').'</td></tr>';

                            foreach ($signupFormData as $d) {
                                if($d['name'] == 'snp-q3-option-no-2-desc' && isset($d['value'])){
                                    $mail->Body .= '<tr><td> </td><td>'.( isset($d['value']) ? $d['value'] : '').'</td></tr>';
                                }
                            }
                        }
                    }
                }
            }

            if($i['name'] == 'snp-q4') {
                if($i['value'] == 'true') {
                    $mail->Body .= '<tr><td>Participated in incubator or accelerator program</td><td>'.(isset($i['value'])?(($i['value'] == 'true')?'YES':'NO') : '').'</td></tr>';
                    foreach ($signupFormData as $da) {
                        if($da['name'] == 'snp-q4-option-yes-1-desc'){
                            $mail->Body .= '<tr><td>  </td><td>'.(isset($da['value'])? $da['value']  : '').'</td></tr>';

                        }
                    }

                }
            }

            if($i['name'] == 'snp-q5') {
                if($i['value'] == 'false') {

                    $mail->Body .= '<tr><td>Raised funds</td><td> NO </td></tr>';

                } elseif ($i['value'] == 'true') {
                    $mail->Body .= '<tr><td>Raised funds</td><td>'.(isset($i['value'])?(($i['value'] == 'true')?'YES':'NO') : '').'</td></tr>';
                    foreach ($signupFormData as $formDa) {
                        if($formDa['name'] == 'snp-q5-yes[]'){
                            $mail->Body .= '<tr><td>  </td><td>'.(isset($formDa['value'])? $formDa['value']  : '').'</td></tr>';
                        }
                    }
                }
            }
        }
        $mail->Body .= '</table>';

        $mail->Body .= '<h2>Product</h2><hr><table style="width:100%">';
        foreach($signupFormData as $i) {
            if($i['name'] == 'snp-product'){
                $mail->Body .= '<tr><td>Product Description</td><td>'.(isset($i['value'])?$i['value']: ''). '</td></tr>';
            }

            if($i['name'] == 'snp-product1') {
                $mail->Body .= '<tr><td>Packaging Designed</td><td>'.(isset($i['value'])?(($i['value'] == 'true')?'YES':'NO') : '').'</td></tr>';
            }

            if($i['name'] == 'snp-product2') {
                $mail->Body .= '<tr><td>Final Prototype</td><td>'.(isset($i['value'])?(($i['value'] == 'true')?'YES':'NO') : '').'</td></tr>';
            }

            if($i['name'] == 'snp-product3[]') {
                if(!isset($firsto)) {
                    $mail->Body .= '<tr><td>Areas of help</td><td>'.(isset($i['value'])?$i['value']: ''). '</td></tr>';
                    $firsto = '111';
                } else {
                    $mail->Body .= '<tr><td> </td><td>'.$i['value'].'</td></tr>';
                }
            }
        }



       $mail->Body .= '</table>';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }

}
